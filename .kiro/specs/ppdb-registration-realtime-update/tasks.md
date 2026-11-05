# PPDB Registration Real-time Update Bugfix - Implementation Tasks

# Implementation Plan:

## Overview

This task list implements the PPDB Registration Real-time Update bugfix using the exploratory bugfix workflow. Tasks are ordered to follow the bug condition methodology: write tests BEFORE implementing the fix to understand the bug, then implement and validate.

---

## Tasks

- [ ] 1. Write bug condition exploration test
  - **Property 1: Bug Condition** - PPDB Registration Event Not Dispatched
  - **CRITICAL**: This test MUST FAIL on unfixed code - failure confirms the bug exists
  - **DO NOT attempt to fix the test or the code when it fails**
  - **NOTE**: This test encodes the expected behavior - it will validate the fix when it passes after implementation
  - **GOAL**: Surface counterexamples demonstrating that `PpdbRegistrationCreated` events are NOT dispatched when registrations are created
  - Write property-based test in `tests/Feature/PpdbRegistrationEventTest.php`
  - Test should verify:
    1. Create a new PPDB registration via `PpdbService::register()` with valid data
    2. Assert the registration is saved to database
    3. Assert that `PpdbRegistrationCreated` event WAS dispatched with registration data
    4. Assert event.broadcastOn() returns channel 'ppdb-registrations'
    5. Assert event.broadcastWith() includes registration ID, name, and status
    6. Test multiple scenarios: single registration, rapid successive registrations
  - **Scoped PBT Approach**: Test with concrete registration data (quantity=1 registration) to ensure reproducibility:
    - Student name: "Test Student", Phone: "08xx", Email: "test@example.com", Parent: "Parent Name"
    - Status: "pending"
  - Use Event fake/mock to assert event was dispatched: `\Illuminate\Support\Facades\Event::fake()`
  - Run test on UNFIXED code
  - **EXPECTED OUTCOME**: Test FAILS (proves event is not currently dispatched)
  - Document the failure reason: "PpdbRegistrationCreated event was never dispatched"
  - Mark task complete when test is written, run, and failure is documented
  - _Requirements: 1.1, 2.1_

- [ ] 2. Write preservation property tests (BEFORE implementing fix)
  - **Property 2: Preservation** - Non-Registration Operations Unchanged
  - **IMPORTANT**: Follow observation-first methodology
  - Write property-based tests in `tests/Feature/PpdbPreservationTest.php`
  - **Observe behavior on UNFIXED code** for non-registration operations:
    - Test search functionality: `PpdbRegistrationsList::getRegistrations()` with search queries
    - Test filtering: status filter 'all', 'pending', 'accepted', 'rejected'
    - Test pagination: create 20 registrations, verify pagination works correctly
    - Test export: CSV export produces correct data format
    - Test existing registrations: query method returns all existing registrations unchanged
  - Implement observation phase FIRST (run tests on unfixed code to record baseline):
    1. Create 5 pre-existing registrations in test setup
    2. Execute non-registration operations
    3. Record observed results (record what the unfixed code returns)
  - Write property-based tests asserting observed behavior:
    - Property: For any search string, unfixed code search results match fixed code results
    - Property: For any status filter value, unfixed code results match fixed code results
    - Property: Pagination state (page, perPage) returns identical data on unfixed and fixed
    - Property: CSV export format and content unchanged
    - Property: Existing registration count and data unchanged
  - Run tests on UNFIXED code
  - **EXPECTED OUTCOME**: Tests PASS (confirms baseline behavior to preserve)
  - Verify all tests pass before moving to implementation
  - Mark task complete when tests are written, run, and passing on unfixed code
  - _Requirements: 3.1, 3.2, 3.3, 3.4_

- [ ] 3. Create `app/Events/PpdbRegistrationCreated.php`
  - Create new event class implementing `ShouldBroadcast`
  - Use traits: `Dispatchable`, `InteractsWithSockets`, `SerializesModels`
  - Constructor accepts `PpdbRegistration $registration` instance
  - Implement `broadcastOn()`: return `[new Channel('ppdb-registrations')]`
  - Implement `broadcastWith()`: return associative array with:
    - `registration_id` - the registration's ID
    - `student_name` - student name
    - `status` - registration status
    - `registration_number` - unique registration number
    - `created_at` - timestamp
    - `parent_name` - parent/guardian name
  - Implement `broadcastAs()`: return 'ppdb.registration.created'
  - Copy pattern from `app/Events/TeacherActivityCreated.php`
  - _Bug_Condition: isBugCondition = event NOT dispatched in original code_
  - _Expected_Behavior: Event SHALL be dispatched with complete registration data_
  - _Requirements: 2.1, 2.2_

- [ ] 4. Create broadcasts table migration
  - Create migration: `php artisan make:migration create_broadcasts_table`
  - File location: `database/migrations/[timestamp]_create_broadcasts_table.php`
  - Create `broadcasts` table with columns:
    - `id` (bigint, primary key)
    - `name` (string, event name)
    - `data` (longText, JSON broadcast data)
    - `created_at` (timestamp)
  - Migration strategy: Check if table doesn't exist before creating
  - _Requirements: 2.3_

- [ ] 5. Create or verify `config/broadcasting.php`
  - Create or verify configuration file at `config/broadcasting.php`
  - Ensure 'database' driver is defined with table 'broadcasts'
  - Configuration should include:
    ```php
    'database' => [
        'driver' => 'database',
        'connection' => null,
        'table' => 'broadcasts',
    ]
    ```
  - This enables local development broadcasting without external services
  - _Requirements: 2.3_

- [ ] 6. Update `.env` to enable database broadcasting
  - Change `BROADCAST_CONNECTION=log` to `BROADCAST_CONNECTION=database`
  - This enables persistent broadcasting instead of sync-only mode
  - Ensure `QUEUE_CONNECTION=database` is set (verify in `.env`)
  - _Requirements: 2.3_

- [ ] 7. Run migrations to create broadcasts table
  - Execute: `php artisan migrate`
  - Verify `broadcasts` table created successfully
  - Confirm no errors during migration
  - _Requirements: 2.3_

- [ ] 8. Update `app/Services/PpdbService.php` to dispatch event
  - Add import at top: `use App\Events\PpdbRegistrationCreated;`
  - In `register()` method, after successful `PpdbRegistration::create($data)`:
    - Add: `PpdbRegistrationCreated::dispatch($registration);` immediately after creation
    - Place dispatch AFTER the registration is successfully saved
    - Place dispatch BEFORE the return statement
    - Keep existing logging and error handling unchanged
  - Event dispatch must occur synchronously (no queue delay) for real-time updates
  - _Bug_Condition: Event currently NOT dispatched, causing no component refresh_
  - _Expected_Behavior: Event SHALL be dispatched to trigger component refresh_
  - _Preservation: All existing logging, error handling, return values unchanged_
  - _Requirements: 2.1, 2.2, 3.1, 3.2_

- [ ] 9. Update `app/Livewire/PpdbRegistrationsList.php` listeners
  - Modify protected `$listeners` property from:
    ```php
    protected $listeners = ['refresh' => '$refresh'];
    ```
    to:
    ```php
    protected $listeners = ['refresh' => '$refresh', 'ppdb:registered' => '$refresh'];
    ```
  - When 'ppdb:registered' event is received, the `$refresh()` method executes
  - This re-renders the component with latest data from `getRegistrations()`
  - No other changes needed to this component
  - _Expected_Behavior: Component auto-refreshes when new registration created_
  - _Preservation: Existing refresh listener, search, and filter functionality unchanged_
  - _Requirements: 2.2, 3.3_

- [ ] 10. Update `app/Livewire/PpdbMonitoringDashboard.php` listeners and cache invalidation
  - Add listener to `$listeners` property (create if doesn't exist):
    ```php
    protected $listeners = ['ppdb:registered' => 'invalidateStats'];
    ```
  - Add new public method to invalidate computed property cache:
    ```php
    public function invalidateStats()
    {
        $this->resetComputed();
    }
    ```
  - Alternative (modern Livewire 3): Use attribute on new method:
    ```php
    #[\Livewire\Attributes\On('ppdb:registered')]
    public function invalidateStats()
    {
        $this->resetComputed();
    }
    ```
  - The `resetComputed()` call clears caches for `#[Computed(cache: true)]` properties
  - This ensures `stats()`, `recentActivities()`, and `searchResults()` re-fetch fresh data
  - _Expected_Behavior: Computed stats refresh when new registration created_
  - _Preservation: Existing statistics calculations, filters, exports unchanged_
  - _Requirements: 2.2, 3.3, 3.4_

- [ ] 11. Verify broadcasting configuration
  - Confirm `.env` settings:
    - `BROADCAST_CONNECTION=database`
    - `QUEUE_CONNECTION=database`
    - `DB_CONNECTION=mysql` with correct credentials
    - `SESSION_DRIVER=database`
  - Verify `config/broadcasting.php` structure:
    - File exists at `config/broadcasting.php`
    - 'database' driver defined in 'connections' array
    - Table name is 'broadcasts'
  - Verify `config/queue.php` settings:
    - File exists at `config/queue.php`
    - 'database' driver is defined
    - 'database' is set as default queue driver or in `.env` QUEUE_CONNECTION
  - Document current values in implementation notes
  - _Requirements: 2.3_

- [ ] 12. Verify bug condition test now passes
  - **Property 1: Expected Behavior** - PPDB Registration Event Dispatched
  - **IMPORTANT**: Re-run the SAME test from task 1 - do NOT write a new test
  - The test from task 1 encodes the expected behavior
  - Execute: `php artisan test tests/Feature/PpdbRegistrationEventTest.php`
  - When this test passes, it confirms the expected behavior is satisfied
  - Verify all assertions pass:
    1. ✓ Registration saved to database
    2. ✓ Event was dispatched
    3. ✓ Event broadcast on 'ppdb-registrations' channel
    4. ✓ Event payload includes registration data
  - **EXPECTED OUTCOME**: Test PASSES (confirms bug is fixed)
  - Document: "Event now dispatched successfully on registration creation"
  - _Requirements: 2.1, 2.2, Expected Behavior Properties from design_

- [ ] 13. Verify preservation tests still pass
  - **Property 2: Preservation** - Non-Registration Operations Unchanged
  - **IMPORTANT**: Re-run the SAME tests from task 2 - do NOT write new tests
  - Execute: `php artisan test tests/Feature/PpdbPreservationTest.php`
  - **EXPECTED OUTCOME**: Tests PASS (confirms no regressions)
  - Verify all preservation properties still hold:
    1. ✓ Search functionality identical to unfixed version
    2. ✓ Status filtering identical to unfixed version
    3. ✓ Pagination behavior unchanged
    4. ✓ CSV export format unchanged
    5. ✓ Existing registrations unchanged
  - Document: "All preservation tests pass - no regressions"
  - Confirm all tests still pass after fix (no regressions)
  - _Requirements: 3.1, 3.2, 3.3, 3.4_

- [ ] 14. Create integration test - full real-time update flow
  - Create `tests/Feature/PpdbRealtimeIntegrationTest.php`
  - Test complete flow: registration submission → event dispatch → Livewire refresh
  - Verify behavior:
    1. Create new PPDB registration via `PpdbService::register()`
    2. Assert event is dispatched immediately
    3. Assert event payload contains all registration data
    4. Simulate Livewire component receiving broadcast event
    5. Assert component's `$refresh()` method is triggered
    6. Assert new registration appears in `PpdbRegistrationsList::getRegistrations()`
    7. Assert new registration appears in monitoring dashboard stats
    8. Assert computed properties are invalidated and re-calculated
  - Test various scenarios:
    - Single registration creation
    - Multiple rapid registrations
    - Registration with different data values
  - Execute: `php artisan test tests/Feature/PpdbRealtimeIntegrationTest.php`
  - Verify all integration tests pass
  - Document: "Integration tests confirm end-to-end real-time flow works"
  - _Requirements: Expected Behavior, Preservation Requirements_

- [ ] 15. End-to-end manual testing in browser
  - Prerequisites:
    - Start development server: `php artisan serve` (user should run manually)
    - Broadcasting table migration must be run: `php artisan migrate`
    - `.env` must have `BROADCAST_CONNECTION=database`
  - Test real-time update in browser:
    1. Open admin dashboard in browser at `http://localhost:8000/admin/ppdb`
    2. Open PPDB registrations list in another browser tab/window
    3. Create a new PPDB registration via the form
    4. Observe: New registration should appear in the list immediately (without refresh)
    5. Verify the data is correct (name, phone, status, etc.)
  - Expected outcomes:
    - ✓ New registration appears instantly in both dashboard and list
    - ✓ Statistics update without manual refresh (count, gender breakdown, etc.)
    - ✓ No console errors in browser DevTools
    - ✓ Network tab shows broadcast messages
  - Test multiple registrations: Create 3 registrations in quick succession
    - All 3 should appear in list without refresh
    - Stats should update correctly
  - Test preservation - manual refresh still works:
    1. Reload page manually (CTRL+R)
    2. Verify all registrations are displayed correctly
    3. Verify pagination, filters, search work as before
    4. Verify export functionality works
  - Expected outcomes:
    - ✓ Manual refresh displays all registrations
    - ✓ No data loss
    - ✓ All UI controls work correctly
  - Test error scenarios:
    1. Temporarily disable broadcasting (set `BROADCAST_CONNECTION=log`)
    2. Create a registration - it should still save to database
    3. New registration may not appear in real-time, but manual refresh works
  - Document results: "Manual testing confirms real-time updates working; preservation verified"
  - _Requirements: All Expected Behavior Properties and Preservation Properties_

- [ ] 16. Final checkpoint - ensure all tests pass
  - Run full test suite: `php artisan test`
  - Verify all tests pass:
    - Bug condition test (Property 1) - PASSES
    - Preservation tests (Property 2) - PASS
    - Integration tests - PASS
    - All other existing tests - PASS (no regressions)
  - Document test results
  - Verify database state:
    - Confirm `broadcasts` table exists: `php artisan tinker` → `\DB::table('broadcasts')->count()`
    - Verify broadcasts are being recorded when events occur
  - Verify implementation completeness:
    - ✓ `app/Events/PpdbRegistrationCreated.php` created
    - ✓ `app/Services/PpdbService.php` modified to dispatch event
    - ✓ `app/Livewire/PpdbRegistrationsList.php` updated with listener
    - ✓ `app/Livewire/PpdbMonitoringDashboard.php` updated with listener and cache invalidation
    - ✓ `.env` updated with `BROADCAST_CONNECTION=database`
    - ✓ `config/broadcasting.php` created/verified
    - ✓ Broadcasts migration created and run
  - Verify no regressions:
    - Manual smoke test: Create registration, verify it appears
    - Verify existing registrations unaffected
    - Verify search, filter, export still work
    - Verify manual refresh works
    - Verify status updates work
  - Document implementation summary and confirm ready for production deployment
  - Ensure no test failures or warnings; ask user if questions arise

---

## Task Dependency Graph

```json
{
  "waves": [
    {
      "label": "Phase 1: Bug Discovery",
      "tasks": ["1", "2"],
      "description": "Write tests on unfixed code to confirm bug exists"
    },
    {
      "label": "Phase 2: Broadcasting Infrastructure",
      "tasks": ["3", "4", "5", "6", "7"],
      "description": "Create event, migration, config, and setup database broadcasting"
    },
    {
      "label": "Phase 3: Integration & Listeners",
      "tasks": ["8", "9", "10", "11"],
      "description": "Dispatch events and add listeners to components"
    },
    {
      "label": "Phase 4: Validation",
      "tasks": ["12", "13", "14", "15", "16"],
      "description": "Verify fix works and no regressions introduced"
    }
  ],
  "dependencies": {
    "1": [],
    "2": [],
    "3": ["1", "2"],
    "4": ["3"],
    "5": ["4"],
    "6": ["5"],
    "7": ["6"],
    "8": ["7"],
    "9": ["8"],
    "10": ["9"],
    "11": ["10"],
    "12": ["11"],
    "13": ["12"],
    "14": ["13"],
    "15": ["14"],
    "16": ["15"]
  }
}
```

---

## Acceptance Criteria Summary

**Bug Condition (Property 1):**
- ✓ New PPDB registrations trigger `PpdbRegistrationCreated` event dispatch
- ✓ Event broadcasts on 'ppdb-registrations' channel
- ✓ Event payload includes: registration ID, student name, status, registration number
- ✓ Livewire components receive broadcast and auto-refresh
- ✓ New registrations appear in admin dashboard immediately without manual refresh

**Preservation (Property 2):**
- ✓ Manual page refresh (CTRL+R) displays all registrations
- ✓ Search functionality identical to unfixed version
- ✓ Status filtering works identically
- ✓ Pagination behavior unchanged
- ✓ CSV export content unchanged
- ✓ Existing registrations unaffected
- ✓ Status updates to existing registrations work
- ✓ All UI controls function identically

**Testing:**
- ✓ Bug condition test FAILS on unfixed code (proves bug exists)
- ✓ Preservation tests PASS on unfixed code (baseline documented)
- ✓ Bug condition test PASSES on fixed code (proves bug fixed)
- ✓ Preservation tests PASS on fixed code (proves no regressions)
- ✓ Integration test verifies full real-time flow
- ✓ Manual testing confirms real-time updates in browser

---

## Notes

- **Real-time Requirement**: Event dispatch MUST be synchronous (not queued) for real-time updates
- **Database Driver**: Using database broadcasting driver suitable for development; can be upgraded to Pusher/Redis for production
- **Cache Invalidation**: `resetComputed()` clears all cached computed properties in PpdbMonitoringDashboard
- **Livewire Version**: Tasks assume Livewire 3.x; adjust syntax if using older versions
- **Broadcasting Table**: Created automatically by migration; stores broadcasts for polling-based updates
- **Error Handling**: Registration creation MUST succeed even if event dispatch fails (graceful degradation)
