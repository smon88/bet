@props([
  'id' => 'loading',
  'text' => 'Estamos procesando tu transacción...',
  'show' => false,
])

<div id="{{ $id }}" class="loading-container hidden">
        <div style="width: 90%; margin-top: 45%;">
            <div class="spinner-container">
                <div class="spinner"></div>
            </div>
        </div>
</div>