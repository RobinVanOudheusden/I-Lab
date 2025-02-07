@include('layouts.app')
        

            <div class="flex items-center justify-center h-screen flex-col">
                
               <div class="flex p-10 bg-white rounded-lg flex-col mx-auto justify-center items-center">
               <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-14 mb-4 w-auto">
                <!-- use -->
                <div class="text-gray-800 text-4xl font-bold flex items-center">
                    <span class="ml-2 font-bold">Welkom bij {{ config('app.name', 'Laravel') }}</span>
                </div>

                <div class="border-t border-gray-300 w-full mt-4"></div>
                <div class="flex gap-4 mt-4 flex-col text-center">
                    <a href="/join-quiz" class="px-8 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-lg text-lg font-semibold hover:bg-opacity-90 transition-colors relative">
                        Join Quiz
                    </a>
                    <a href="/teacher/login" class="px-8 py-3 bg-gradient-to-r from-green-500 to-blue-500 text-white rounded-lg text-lg font-semibold hover:bg-opacity-90 transition-colors relative">
                        Inloggen als docent
                    </a>
                    <a href="/admin/login" class="px-8 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg text-lg font-semibold hover:bg-opacity-90 transition-colors relative">
                        Inloggen als beheerder
                    </a>
                    </div>
                </div>
            </div>
        </div>
        <style>
            body {
                font-family: 'Poppins', sans-serif;
            }
        </style>
    </body>
</html>
