<div wire:poll-3000ms>
  @if($this->activities->count() > 0)
    <div style="display: flex; flex-direction: column; gap: 12px;">
      @foreach($this->activities as $activity)
        <div style="padding: 16px; border-left: 4px solid var(--primary); background: #f8f9fa; border-radius: 6px; display: flex; gap: 12px;">
          <div style="flex-shrink: 0;">
            <i class="fa-solid {{ $activity->getActivityIcon() }}" style="font-size: 1.5rem; color: var(--primary); width: 40px; text-align: center;"></i>
          </div>
          <div style="flex: 1; min-width: 0;">
            <div style="display: flex; justify-content: space-between; gap: 8px; flex-wrap: wrap;">
              <strong style="color: #2c3e50;">{{ $activity->getActivityTypeLabel() }}</strong>
              <small style="color: #7f8c8d; white-space: nowrap;">{{ $activity->created_at->diffForHumans() }}</small>
            </div>
            <p style="margin: 6px 0 0; color: #555; font-size: 0.9rem;">{{ $activity->description }}</p>
            @if($activity->registration)
              <small style="color: #3498db; display: block; margin-top: 4px;">
                <strong>{{ $activity->registration->student_name }}</strong> ({{ $activity->registration->registration_number }})
              </small>
            @endif
            @if($activity->metadata && isset($activity->metadata[''status_from'']) && isset($activity->metadata[''status_to'']))
              <div style="margin-top: 6px; font-size: 0.85rem; color: #666;">
                <span style="background: #ffe0e0; padding: 2px 6px; border-radius: 3px;">{{ $activity->metadata[''status_from''] }}</span>
                <i class="fa-solid fa-arrow-right" style="margin: 0 4px;"></i>
                <span style="background: #e0ffe0; padding: 2px 6px; border-radius: 3px;">{{ $activity->metadata[''status_to''] }}</span>
              </div>
            @endif
          </div>
        </div>
      @endforeach

      @if($this->limit < 50)
        <div style="text-align: center; margin-top: 12px;">
          <button wire:click="loadMore" class="btn-login" style="padding: 8px 16px; border: 0; cursor: pointer; border-radius: 6px;">
            <i class="fa-solid fa-plus"></i> Load More
          </button>
        </div>
      @endif
    </div>
  @else
    <div style="text-align: center; padding: 24px; color: #7f8c8d;">
      <i class="fa-solid fa-inbox" style="font-size: 2rem; margin-bottom: 12px; display: block;"></i>
      <p>Tidak ada aktivitas terbaru</p>
    </div>
  @endif
</div>
