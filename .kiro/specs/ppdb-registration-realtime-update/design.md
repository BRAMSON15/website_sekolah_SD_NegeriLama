# PPDB Registration Real-time Update Bugfix Design

## Overview

The PPDB (Penerimaan Peserta Didik Baru) registration system has a critical issue where newly saved registrations do not automatically appear in the admin monitoring panel without a manual page refresh (CTRL+R). This breaks the real-time monitoring experience and prevents administrators from seeing new applications instantly.

The root cause is a missing event-driven architecture: the system creates registrations in the database but never broadcasts events that trigger Livewire components to refresh. While the Livewire listener infrastructure exists (`protected $listeners = ['refresh' => '$refresh']`), no events are dispatched to trigger these listeners.

This design addresses the complete end-to-end flow: from registration creation through event dispatch to Livewire component updates, using the existing `TeacherActivityCreated` event pattern as a template and configuring broadcasting to work with local development constraints (using the database driver).

## Glossary

- **Bug_Condition (C)**: A new PPDB registration is created and saved to the database, but Livewire components listening for updates do not receive any broadcast event
- **Property (P)**: When a new registration is created, Livewire components (PpdbRegistrationsList, PpdbMonitoringDashboard) should automatically refresh and display the new registration without requiring a manual page refresh
- **Preservation**: All existing behavior must remain unchanged—manual page refreshes, CSV exports, PDF generation, status updates, and existing mouse-click interactions must continue working exactly as before
- **PpdbRegistrationCreated Event**: A new event that implements `ShouldBroadcast` and broadcasts registration data on the 'ppdb-registrations' channel
- **Broadcast Channel**: 'ppdb-registrations' — the channel on which all PPDB-related events are broadcast (public channel, accessible to all connected clients)
- **Livewire Listener**: A protected property in Livewire components that maps event names to methods (e.g., `['refresh' => '$refresh']` listens for the 'refresh' event)
- **Computed Property**: Livewire's `#[Computed]` attribute that caches method results; must be invalidated when underlying data changes
- **Broadcasting Table**: The `broadcasts` table created by the database broadcasting driver that stores broadcast records for retrieval by clients
- **Event Dispatch**: The act of calling `dispatch()` on an event to trigger its broadcast and listeners
- **PpdbService**: The service layer (`app/Services/PpdbService.php`) responsible for registration creation logic
- **PpdbMonitoringService**: The service layer (`app/Services/PpdbMonitoringService.php`) providing monitoring statistics and activity data

## Bug Details

### Bug Condition

The bug manifests when a new PPDB registration is created through the application (via the registration form or admin interface). The registration is successfully saved to the database, but administrators viewing the monitoring dashboard do not see the new registration until they manually refresh the page.

The `PpdbService::register()` method creates a registration and logs it, but it does NOT emit any broadcast event that would trigger Livewire listeners. Although `PpdbRegistrationsList` component defines `protected $listeners = ['refresh' => '$refresh']`, no event ever dispatches to invoke this listener.

**Formal Specification:**
```
FUNCTION isBugCondition(input)
  INPUT: input of type RegistrationData (array with student_name, parent_name, phone, etc.)
  OUTPUT: boolean
  
  RETURN (PpdbRegistration created with input) 
         AND (Registration saved to database) 
         AND (PpdbRegistrationCreated event NOT dispatched)
         AND (Livewire listeners NOT triggered)
         AND (Admin panel does NOT auto-refresh)
END FUNCTION
```

### Examples

**Example 1: Registration Created via Public Form**
- User submits PPDB registration form with name "Andi Wijaya"
- PpdbService::register() creates record, saves to database
- **Expected**: Registration appears instantly in admin dashboard
- **Actual**: Registration does not appear; admin must refresh page manually
- **Root Cause**: No event emitted, so Livewire listeners never triggered

**Example 2: Registration Created via Admin Panel**
- Admin creates new registration via admin interface
- PpdbService::register() called, record saved
- **Expected**: Registration list component auto-updates, computed stats recalculate
- **Actual**: Stats remain cached, registration not visible in list
- **Root Cause**: PpdbMonitoringService caches stats for 3 minutes, no event to invalidate cache

**Example 3: Multiple Registrations in Quick Succession**
- Admin creates 3 registrations rapidly (e.g., uploading batch)
- **Expected**: All 3 registrations visible immediately in monitoring dashboard
- **Actual**: None visible until manual refresh; multiple manual refreshes required to see all
- **Root Cause**: Each registration creation triggers no event; no mechanism to refresh

**Edge Case: Broadcasting Configuration Issue**
- BROADCAST_CONNECTION=log (sync-only mode, no persistent broadcasting)
- **Expected**: Events still broadcast synchronously; Livewire receives updates
- **Actual**: Even if events are dispatched, broadcasting may not work properly
- **Root Cause**: Broadcasting driver must be configured and migration created

## Expected Behavior

### Preservation Requirements

**Unchanged Behaviors:**
- Manual page refresh (CTRL+R) continues to work and displays all registrations
- CSV/PDF export functionality continues to generate correct files with all current registrations
- Status updates to existing registrations (accepted/rejected) continue to work
- Manual click operations on buttons/links work exactly as before
- Registration form submission and validation work exactly as before
- Pagination, search filters, and status filters continue to work
- Database queries and models remain functionally identical
- Existing logs and error handling remain unchanged

**Scope:**
All inputs and operations that do NOT involve creating a new registration should be completely unaffected by this fix. This includes:
- Viewing/searching existing registrations
- Updating registration status
- Adding notes or comments
- Uploading supporting files
- Exporting data
- Refreshing the page manually
- Navigating between pages
- Using UI filter controls

## Hypothesized Root Cause

Based on the bug description and code analysis, the issues are:

1. **Missing Event Creation**: No `PpdbRegistrationCreated` event exists in `app/Events/`. The system has `TeacherActivityCreated` but lacks the PPDB equivalent.

2. **No Event Dispatch in PpdbService**: The `PpdbService::register()` method creates records but never calls `PpdbRegistrationCreated::dispatch()`. Event dispatch must be added after successful registration creation.

3. **Incomplete Broadcasting Configuration**: The `.env` file shows `BROADCAST_CONNECTION=log` (synchronous-only mode). While this works locally, the broadcasting table migration (`broadcasts` table) may not exist, and the `config/broadcasting.php` may not be properly configured for database driver.

4. **Computed Property Cache Not Invalidated**: `PpdbMonitoringDashboard` uses `#[Computed(cache: true)]` for stats. When a new registration is created, the cached stats become stale. While the event will be broadcast, the component needs to listen and invalidate the cache.

5. **Livewire Listeners Defined but Never Invoked**: `PpdbRegistrationsList` has listeners defined (`protected $listeners = ['refresh' => '$refresh']`) but no component ever dispatches the 'refresh' event, so listeners never execute.

## Correctness Properties

Property 1: Bug Condition - PPDB Registration Real-time Broadcast

_For any_ new PPDB registration where a user successfully completes the registration form or admin creates a registration, the fixed `PpdbService::register()` function SHALL emit a `PpdbRegistrationCreated` event on the 'ppdb-registrations' broadcast channel. This event SHALL trigger all listening Livewire components to automatically refresh and display the new registration instantly without requiring a manual page refresh.

**Validates: Requirements 2.1, 2.2, 2.3**

Property 2: Preservation - Non-Registration Operations Unchanged

_For any_ operation that is NOT a new registration creation (viewing registrations, exporting data, updating status, filtering, searching, manually refreshing, clicking buttons), the fixed code SHALL produce exactly the same behavior as the original code, preserving all existing functionality without any changes to response times, data accuracy, or UI behavior.

**Validates: Requirements 3.1, 3.2, 3.3, 3.4**

## Fix Implementation

### Changes Required

Assuming our root cause analysis is correct, the following changes are required:

**File 1**: `app/Events/PpdbRegistrationCreated.php` (new file)

**Changes**: Create a new event that implements `ShouldBroadcast` and broadcasts new registration data
- Create event class with constructor accepting registration ID and registration data
- Implement `broadcastOn()` to return the 'ppdb-registrations' channel
- Implement `broadcastWith()` to include registration details in the broadcast payload
- Implement `broadcastAs()` to identify the event as 'ppdb.registration.created'
- Use the `Dispatchable`, `InteractsWithSockets`, and `SerializesModels` traits (following TeacherActivityCreated pattern)

**File 2**: `app/Services/PpdbService.php`

**Specific Changes**:
1. **Import Event**: Add `use App\Events\PpdbRegistrationCreated;` at the top of the file
2. **Dispatch Event in register()**: After successful `PpdbRegistration::create()`, add `PpdbRegistrationCreated::dispatch($registration)` to emit the event
3. **Timing**: Dispatch must occur AFTER the registration is successfully created and saved, so the event includes complete data

**File 3**: `config/broadcasting.php`

**Changes**: Ensure the database driver is properly configured for local development
- Verify 'database' driver is defined with the correct table name ('broadcasts')
- No external dependencies needed; uses existing database connection

**File 4**: `database/migrations/[timestamp]_create_broadcasts_table.php` (new migration)

**Changes**: Create the broadcasts table if it doesn't exist
- Create 'broadcasts' table with columns: id, name, data, created_at
- This table stores broadcast records for retrieval by clients when database driver is used

**File 5**: `app/Livewire/PpdbMonitoringDashboard.php`

**Specific Changes**:
1. **Add Event Listener**: Add `protected $listeners = ['ppdb:registered' => 'invalidateStats'];` to listen for registration events
2. **Add Invalidate Method**: Create public method `invalidateStats()` that calls `$this->resetComputed()` or `Cache::forget('ppdb.monitoring.stats')` to clear cached stats
3. **Alternative**: Use `#[\Livewire\Attributes\On('ppdb:registered')]` attribute on a method instead of `$listeners` (modern Livewire approach)

**File 6**: `app/Livewire/PpdbRegistrationsList.php`

**Specific Changes**:
1. **Update Listener**: Modify existing listener from `['refresh' => '$refresh']` to include the new event: `['refresh' => '$refresh', 'ppdb:registered' => '$refresh']`
2. **Explanation**: This ensures that when `PpdbRegistrationCreated` is broadcast as 'ppdb:registered', it triggers the `$refresh` method, which re-renders the component with updated data
3. **Alternative (Modern)**: Add method with attribute: `#[\Livewire\Attributes\On('ppdb:registered')] public function refreshRegistrations() { $this->resetPage(); }`

**File 7**: `.env` (configuration update)

**Changes**: If not already set, ensure `BROADCAST_CONNECTION=database` for local development
- Current value is `BROADCAST_CONNECTION=log` (sync-only, minimal broadcasting)
- Change to `BROADCAST_CONNECTION=database` to use database driver
- Database driver suitable for development and small deployments

**File 8**: `config/queue.php` (verify configuration)

**Verification**: Ensure queue driver is set to 'database' or 'sync' for event dispatch
- Events implement `ShouldBroadcast`, so queue must be configured
- Current `.env` shows `QUEUE_CONNECTION=database`, which is correct
- No changes needed if already set to database or sync

### Implementation Sequence

**Phase 1: Create Event and Broadcasting Foundation**
1. Create `PpdbRegistrationCreated` event class following `TeacherActivityCreated` pattern
2. Create `broadcasts` migration table to support database broadcasting driver
3. Update `.env` to set `BROADCAST_CONNECTION=database` (if using database driver)
4. Run migrations: `php artisan migrate`

**Phase 2: Emit Event from Service Layer**
1. Update `PpdbService::register()` to dispatch `PpdbRegistrationCreated` after successful creation
2. Verify event dispatch doesn't break existing error handling
3. Add logging to confirm event is dispatched

**Phase 3: Add Listeners to Livewire Components**
1. Update `PpdbRegistrationsList::$listeners` to include 'ppdb:registered'
2. Add `invalidateStats()` method to `PpdbMonitoringDashboard` and add listener
3. Ensure computed properties are properly invalidated

**Phase 4: Verify End-to-End Flow**
1. Test registration creation and verify event is broadcast
2. Test Livewire components receive event and auto-refresh
3. Test multiple rapid registrations
4. Test that manual refresh still works
5. Test existing functionality unchanged

## Testing Strategy

### Validation Approach

The testing strategy follows a two-phase approach: first, surface counterexamples that demonstrate the bug exists in the unfixed code by showing that Livewire components do NOT refresh after registration creation. Then, verify the fix works by confirming event dispatch triggers component refresh, and verify preservation by ensuring all non-registration operations remain unchanged.

### Exploratory Bug Condition Checking

**Goal**: Surface counterexamples that demonstrate the bug BEFORE implementing the fix. Confirm that new registrations save to the database but Livewire does NOT auto-refresh. This validates our root cause hypothesis that events are not being dispatched.

**Test Plan**: Write integration tests that:
1. Create a new PPDB registration via `PpdbService::register()`
2. Query the database to confirm the registration was saved
3. Attempt to observe Livewire component state to verify it did NOT auto-refresh
4. Confirm that no broadcast event was emitted (check if event was never fired)

**Test Cases**:
1. **Registration Save Without Event Dispatch** (will fail on unfixed code):
   - Call `PpdbService::register()` with valid data
   - Assert registration is saved to database
   - Assert `PpdbRegistrationCreated` event was NOT dispatched
   - Assert Livewire listeners were NOT triggered

2. **Dashboard Stats Not Updated on New Registration** (will fail on unfixed code):
   - Get initial stats count from `PpdbMonitoringService::getMonitoringStats()`
   - Create a new registration
   - Query stats again
   - On unfixed code: stats may be cached and not reflect new registration immediately

3. **Registration List Does Not Refresh** (will fail on unfixed code):
   - Load `PpdbRegistrationsList` component
   - Create a new registration in separate process/request
   - Attempt to verify new registration appears in component without manual refresh
   - On unfixed code: new registration will not appear

4. **Multiple Rapid Registrations Invisible** (will fail on unfixed code):
   - Create 3 registrations in rapid succession
   - Check if all 3 are visible in admin panel without refresh
   - On unfixed code: none will be visible until manual refresh

**Expected Counterexamples**:
- Registration created and saved to database, but does not appear in Livewire component
- Event broadcast not sent/received by components
- Possible causes: (1) Event class doesn't exist, (2) Event not dispatched from service, (3) Broadcasting not configured, (4) Listeners not defined

### Fix Checking

**Goal**: Verify that for all inputs where the bug condition holds (new registration created), the fixed function produces the expected behavior (event dispatched, components refresh).

**Pseudocode:**
```
FOR ALL input WHERE isBugCondition(input) DO
  registration := PpdbService::register(input)
  ASSERT registration.id is not null
  ASSERT PpdbRegistrationCreated event WAS dispatched
  ASSERT event.broadcastOn() includes 'ppdb-registrations'
  ASSERT event.broadcastWith() includes registration data
  ASSERT Livewire listeners received the event
  ASSERT PpdbRegistrationsList component refreshed
  ASSERT PpdbMonitoringDashboard cache invalidated
  ASSERT new registration appears in dashboard without manual refresh
END FOR
```

### Preservation Checking

**Goal**: Verify that for all inputs where the bug condition does NOT hold (viewing, searching, exporting, etc.), the fixed code produces the same result as the original code.

**Pseudocode:**
```
FOR ALL input WHERE NOT isBugCondition(input) DO
  ASSERT PpdbService_original(input) = PpdbService_fixed(input)
  ASSERT PpdbMonitoringService_original(input) = PpdbMonitoringService_fixed(input)
  ASSERT Livewire_original_render(input) = Livewire_fixed_render(input)
END FOR
```

**Testing Approach**: Property-based testing is recommended for preservation checking because:
- It generates many test cases automatically across the input domain (search strings, filters, exports)
- It catches edge cases that manual unit tests might miss (empty searches, special characters, boundary conditions)
- It provides strong guarantees that behavior is unchanged for all non-buggy inputs (viewing, exporting, filtering)

**Test Plan**: Observe behavior on UNFIXED code first for non-registration operations, then write property-based tests capturing that behavior to ensure preservation after fix.

**Test Cases**:

1. **Export Preservation**: Verify CSV/PDF export on unfixed code works correctly, then write test to verify output is identical after fix
   - Export with status filter
   - Export with date range
   - Verify file content is identical

2. **Search Preservation**: Verify search functionality works on unfixed code, then write test to verify results are identical after fix
   - Search by student name
   - Search by registration number
   - Search by parent name
   - Property test: for any search string, unfixed and fixed search results are identical

3. **Status Filter Preservation**: Verify filtering works on unfixed code, then write test to verify results after fix
   - Filter by 'pending' status
   - Filter by 'accepted' status
   - Property test: for any status value, unfixed and fixed results match

4. **Pagination Preservation**: Verify pagination on unfixed code, then write test to verify behavior after fix
   - Navigate between pages
   - Change items per page
   - Property test: pagination state remains consistent

5. **Manual Refresh Preservation**: Verify manual page refresh works on unfixed code, then write test to verify it still works after fix
   - Page refresh displays latest registrations
   - No data loss on refresh

6. **Update Status Preservation**: Verify changing registration status works on unfixed code, then write test to verify after fix
   - Update status from 'pending' to 'accepted'
   - Verify status change persists and appears in list

### Unit Tests

- Test `PpdbRegistrationCreated` event broadcasts on correct channel with correct data
- Test `PpdbService::register()` dispatches event with correct registration data
- Test event payload includes all necessary registration information
- Test Livewire listeners receive events and trigger refresh
- Test computed property cache invalidation works
- Test error handling: event dispatch failure doesn't prevent registration save
- Test event dispatch with various registration data scenarios

### Property-Based Tests

- **Property 1**: For any valid registration data, after creation, event is dispatched and contains all registration fields
- **Property 2**: For any search query, search results on unfixed and fixed code are identical
- **Property 3**: For any status filter value, filter results on unfixed and fixed code are identical
- **Property 4**: For any export operation, CSV content on unfixed and fixed code is identical
- **Property 5**: Creating a registration and immediately querying the list returns the new registration in fixed code (without manual refresh)

### Integration Tests

- Test complete flow: user submits registration form → database saves → event broadcast → Livewire refreshes → new registration visible
- Test multiple registrations created in succession → all visible in dashboard
- Test registration created via different entry points (public form, admin panel) → all trigger event and display
- Test context switching: create registration while viewing different page → notification/update still works
- Test visual feedback: verify UI shows new registration with correct styling and data
- Test broadcast table cleanup: verify old broadcasts are handled appropriately
- Test fallback: if broadcasting fails, registration still saves (graceful degradation)

