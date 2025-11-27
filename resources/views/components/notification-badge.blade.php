@props(['count' => 0, 'type' => 'info'])

@if($count > 0)
<span class="badge badge-{{ $type }} navbar-badge">{{ $count > 99 ? '99+' : $count }}</span>
@endif