@include('layouts.app')

<!-- component -->
<link rel="stylesheet" href="https://demos.creative-tim.com/notus-js/assets/styles/tailwind.css">
<link rel="stylesheet" href="https://demos.creative-tim.com/notus-js/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">


<section class="py-1 bg-blueGray-50 w-full h-full">
<div class="w-full xl:w-8/12 mb-12 xl:mb-0 px-4 mx-auto mt-24">
  <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded ">
    <div class="rounded-t mb-0 px-4 py-3 border-0">
      <div class="flex flex-wrap items-center">
        <div class="relative w-full px-4 max-w-full flex-grow flex-1">
          <h3 class="font-semibold text-base text-blueGray-700">Alle quizzes</h3>
        </div>
      </div>
    </div>

    <div class="block w-full overflow-x-auto">
      <table class="items-center bg-transparent w-full border-collapse ">
        <thead>
          <tr>
            
            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
            <i class="fa-solid fa-pencil"></i>             
            Quiz name
                        </th>
          <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
            <i class="fa-solid fa-hashtag"></i>
          Quiz ID
                        </th>
          </tr>
        </thead>


        @foreach ($quizzes as $quiz)
        <!-- make the uneven rows have a different color -->
        <tbody>
        <tr class="{{ $loop->index % 2 == 0 ? 'bg-blueGray-50' : 'bg-blueGray-50' }}">
          <td class="px-6 bg-blueGray-50 text-sky-500 underline align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
            <a href="{{ route('quiz.edit', $quiz->id) }}">{{ $quiz->name }}</a>
          </td>
          <td class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
            {{ $quiz->id }}
          </td> 
        </tr>
        </tbody>
        @endforeach

      </table>
    </div>
  </div>
</div>
</section>
    