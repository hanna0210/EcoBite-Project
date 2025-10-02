<div class="border rounded-sm p-2 space-x-2 space-y-1 {{ count($items ?? []) == 0 ?'hidden':'flex flex-wrap' }}">
  @foreach ($items ?? [] as $item)
      
      <div class="flex items-center justify-center px-2 py-1 m-1 font-medium bg-white border rounded-full text-primary-500 border-primary-500 ">
          <div class="flex-initial max-w-full text-xs font-normal leading-none">
              {{ $item->name }}</div>
          <div class="flex flex-row-reverse flex-auto">
              <div wire:click="{{ $onRemove ?? 'removeItem' }}({{ $item->id ?? $item['id'] ?? '' }})">
                  <svg class="w-4 h-4 ml-2 rounded-full cursor-pointer feather feather-x hover:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                  </svg>
              </div>
          </div>
      </div>
      
  @endforeach
</div>