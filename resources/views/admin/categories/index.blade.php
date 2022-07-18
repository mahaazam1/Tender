@extends('admin.layouts.main')
@section('content')


<div
      class="flex h-screen bg-gray-50 dark:bg-gray-900"
      :class="{ 'overflow-hidden': isSideMenuOpen}"
    >
        
      <div class="flex flex-col flex-1 w-full">
        <main class="h-full pb-16 overflow-y-auto">
          <div class="container grid px-6 mx-auto">
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
            Categories
            </h2>

            
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
    
     
              <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                  <thead>
                    <tr
                      class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                      <th class="px-4 py-3">Category image</th>
                      <th class="px-4 py-3">Category name</th>
                      <th class="px-4 py-3">Actions</th>
                    </tr>
                  </thead>
                  <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">

                	@foreach ($categories as $category)
                    	 <tr class="text-gray-700 dark:text-gray-400">
                          <td class="px-4 py-3">
                         <div class="flex items-center text-sm">
                          <div
                            class="relative hidden w-9 h-9 mr-1 md:block"
                          >   

                             
                            <img style="height: 80px; width: 100px;" 
                              class="object-cover "
                              src="{{asset('storage/'. $category->image)}}?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=100&fit=max&ixid=eyJhcHBfaWQiOjE3Nzg0fQ"
                              alt=""
                              loading="lazy">
                            <div
                              class="absolute inset-0 rounded-full shadow-inner"
                              aria-hidden="true"
                            ></div>
                          </div>
                        
                        </div>
                      </td>
                      <td class="px-4 py-3">
                        {{$category->name}}
                      </td>
                      
                      <td class="px-4 py-3">
                        <div class="flex items-center space-x-2 text-sm">
							<form method="" action="{{URL('category/edit/'.$category->id)}}">
                          	<input type="hidden" name="_token" value="{{csrf_token()}}">
                          <button type="submit" 
                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-green-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                            aria-label="Edit">

                            <svg
                              class="w-5 h-5"
                              aria-hidden="true"
                              fill="currentColor"
                              viewBox="0 0 20 20"
                            >
                              <path
                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"
                              ></path>
                            </svg>
                          </button>
                      </form>
                          <form method="POST" action="{{URL('category/destroy/'.$category->id)}}">
                          	<input type="hidden" name="_token" value="{{csrf_token()}}">

                          	<button type="submit" 
                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-green-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                            aria-label="Delete"
                          >
                            <svg
                              class="w-5 h-5"
                              aria-hidden="true"
                              fill="currentColor"
                              viewBox="0 0 20 20"
                            >
                              <path
                                fill-rule="evenodd"
                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                clip-rule="evenodd"
                              ></path>
                            </svg>
                          </button>
                          </form>
                          
                        </div>
                      </td>

                    </tr>
                	@endforeach
                   

                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>

@endsection
