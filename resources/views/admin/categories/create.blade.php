@extends('admin.layouts.main')
@section('content')

 <main class="h-full pb-16 overflow-y-auto">
          <div class="container px-6 mx-auto grid">
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Create Category
            </h2>

            <div>
              @if(session()->has('status'))
                @if(session('status'))
                  <h2>Sucess</h2>
                @else
                  <h2>fffff</h2>
                @endif

              @endif
            </div>
      
            <div
              class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800" 
              style="width: 432px; ">

              <form action="{{URL('category/store')}}" method="POST" enctype="multipart/form-data">
                  <input type="hidden" name="_token" value="{{csrf_token()}}">

              	  <label class="block text-sm">
                	<span class="text-gray-700 dark:text-gray-400">Name</span>
                	<input name="name" id="name" 
	                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
	                  placeholder="category name" />
	                </label>
                  <br>
                  <label class="block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Image</span>
                  <input type="file" name="image" id="image" 
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    />
                  </label>
                  
	                <div class="mt-4 text-sm">
	                	<button class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
	                  save
	                </button>

	              </div>
              </form>
              
            </div>
            </div>
 
        </main>

@endsection