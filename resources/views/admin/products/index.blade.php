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
            Approval of products
            </h2>

            
            <div class="w-full overflow-hidden rounded-lg shadow-xs">

     
              <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                  <thead>
                    <tr
                      class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                      <th class="px-4 py-3">Product</th>
                      <th class="px-4 py-3">Name</th>
                      <th class="px-4 py-3">Price</th>
                      <th class="px-4 py-3">Category</th>
                      <th class="px-4 py-3">Action</th>

                    </tr>
                  </thead>
                  <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">

                	@foreach($products as $product)
                    	 <tr class="text-gray-700 dark:text-gray-400">
                          <td class="px-4 py-3">
                         <div class="flex items-center text-sm">
                          <div
                            class="relative hidden w-9 h-9 mr-1 md:block"
                          >   

                             
                            <img style="height: 80px; width: 100px;" 
                              class="object-cover "
                              src="{{asset('storage/'. $product->image)}}?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=100&fit=max&ixid=eyJhcHBfaWQiOjE3Nzg0fQ"
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
                        <h4>{{$product->name}}</h4>
                        <p style="font-size:60%;">by
                        @foreach($users as $user)
                        @if($user->id == $product->user_id)
                        {{$user->name}}
                        @endif
                        @endforeach
                      </p>
                      
                      </td>
                      <td class="px-4 py-3">
                      {{$product->price}}
                      </td>
                      <td class="px-4 py-3">
                      @php $categories = $product->category; @endphp
                       		@if(!empty($categories))
                            	{{$categories->name}}
                        	@endif
                      </td>
                      
                      <td class="px-4 py-3">
                        <div class="flex items-center space-x-2 text-sm">
							<form method="POST" action="{{URL('products/approval/'.$product->id)}}">
                          	<input type="hidden" name="_token" value="{{csrf_token()}}">
                          <button type="submit" 
                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-green-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                            aria-label="Edit">

                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" 
                            fill="currentColor" class="bi bi-check-square-fill" viewBox="0 0 16 16">
                            <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z"/>
                            </svg>
                          </button>
                      </form>
                          <form method="POST" action="{{URL('products/disapproval/'.$product->id)}}">
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
                <div style="margin: 20px;" class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                  {{$products->links()}}
                </div>
              
              </div>
              @if($products->isEmpty())
                <div>
                  <br>
            				<h4 style="text-align:center;">There are no products that need approval</h4>
                    <br>
            			</div>
            		@endif
            </div>
          </div>
        </main>
      </div>
    </div>

@endsection
