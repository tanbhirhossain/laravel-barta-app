@extends('frontend.layouts.master')
@section('page-title', 'Home | Barta')
@section('content')
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form
   method="POST"
   enctype="multipart/form-data"
   @if(isset($post))
       action="{{ route('post.update', $post->id) }}"
   @else
       action="{{ route('post.store') }}"
   @endif
   class="bg-white border-2 border-black rounded-lg shadow mx-auto max-w-none px-4 py-5 sm:px-6 space-y-3">
   @csrf
   @if(isset($post))
       @method('PUT')
   @endif
   <!-- Create Post Card Top -->
   <div>
      <div class="flex items-start /space-x-3/">
         <!-- Content -->
         <div class="text-gray-700 font-normal w-full">
            <textarea
               class="block w-full p-2 pt-2 text-gray-900 rounded-lg border-none outline-none focus:ring-0 focus:ring-offset-0"
               name="post_text"
               rows="2"
               placeholder="What's going on, {{Auth::user()->name}}?"
            >{{ isset($post) ? $post->post_text : '' }}</textarea>
         </div>
      </div>
   </div>
   <!-- Create Post Card Bottom -->
   <div>
      <!-- Card Bottom Action Buttons -->
      <div class="flex items-center justify-end">
         <div>
            <!-- Post Button -->
            <button
               type="submit"
               class="-m-2 flex gap-2 text-xs items-center rounded-full px-4 py-2 font-semibold bg-gray-800 hover:bg-black text-white">
               @if(isset($post))
                   Update Post
               @else
                   Post
               @endif
            </button>
            <!-- /Post Button -->
         </div>
      </div>
      <!-- /Card Bottom Action Buttons -->
   </div>
   <!-- /Create Post Card Bottom -->
</form>
<!-- /Barta Create Post Card -->
<!-- Newsfeed -->
<section
   id="newsfeed"
   class="space-y-6">
   <!-- Barta Card -->
   
   @foreach ($posts as $item)
   <article
   class="bg-white border-2 border-black rounded-lg shadow mx-auto max-w-none px-4 py-5 sm:px-6">
   <!-- Barta Card Top -->
   <header>
      <div class="flex items-center justify-between">
         <div class="flex items-center space-x-3">
            <!-- User Info -->
            <div class="text-gray-900 flex flex-col min-w-0 flex-1">
               <a
                  href="#"
                  class="hover:underline font-semibold line-clamp-1">
               {{ $item->user->name }}
               </a>
               <a
                  href="profile.html"
                  class="hover:underline text-sm text-gray-500 line-clamp-1">
               {{"@".$item->user->name}}
               </a>
            </div>
            <!-- /User Info -->
         </div>
         <!-- Card Action Dropdown -->
         <div class="flex flex-shrink-0 self-center" x-data="{ open: false }">
            <div class="relative inline-block text-left">
               <div>
                  <button
                     @click="open = !open"
                     type="button"
                     class="-m-2 flex items-center rounded-full p-2 text-gray-400 hover:text-gray-600"
                     id="menu-0-button">
                     <span class="sr-only">Open options</span>
                     <svg
                        class="h-5 w-5"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        aria-hidden="true">
                        <path
                           d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM11.5 15.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z"></path>
                     </svg>
                  </button>
               </div>
               <!-- Dropdown menu -->
               <div
                  x-show="open"
                  @click.away="open = false"
                  class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                  role="menu"
                  aria-orientation="vertical"
                  aria-labelledby="user-menu-button"
                  tabindex="-1">
                  <a
                     href="{{ route('post.edit', $item->id) }}"
                     class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                     role="menuitem"
                     tabindex="-1"
                     id="user-menu-item-0"
                     >Edit</a
                     >
                     <form
                     action="{{ route('post.destroy', $item->id) }}"
                     method="POST"
                     onsubmit="return confirm('Are you sure you want to delete this post?');">
                     @csrf
                     @method('DELETE')
                     <button
                         type="submit"
                         class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                         role="menuitem"
                         tabindex="-1"
                         id="user-menu-item-1"
                         >Delete</button>
                 </form>
               </div>
            </div>
         </div>
         <!-- /Card Action Dropdown -->
      </div>
   </header>
   <!-- Content -->
   <div class="py-4 text-gray-700 font-normal">
      {{-- <p>
         🎉🥳 Turning 20 today! 🎂
         <br />
         One of the best things in my life has been my love affair with
         <a
            href="#laravel"
            class="text-black font-semibold hover:underline"
            >#Laravel</a
            >
         <br />
         <br />
         Keep me in your prayers 😌 --}}

         {!! $item->post_text !!}
      </p>
   </div>
   <!-- Date Created & View Stat -->
   <div class="flex items-center gap-2 text-gray-500 text-xs my-2">
      <span class="">{{ $item->timeAgo }}</span>
      <span class="">•</span>
      <span>450 views</span>
   </div>
</article>
   @endforeach
  

</section>
<!-- /Newsfeed -->
@endsection

@section('js')
    <script>
        @if(Session::has('success'))
            toastr.success("{{ Session::get('success') }}")
        @endif

        @if(Session::has('error'))
            toastr.error("{{ Session::get('error') }}")
        @endif

    </script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    // Initialize Toastr
    $(document).ready(function() {
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
    });
</script>

@endsection