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
            Search Results
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
                      <th class="px-4 py-3">Status</th>


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
                      @if($product->status == 1)
                      <td class="px-4 py-3 text-xs">
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"
                        >
                          Approved
                        </span>
                      </td>
                      @else
                      <td class="px-4 py-3 text-xs">
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-700"
                        >
                          Denied
                        </span>
                      </td>
                      @endif 
                      
 
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
