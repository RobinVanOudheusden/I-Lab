@include('layouts.app')
@include('layouts.header')
        <div class="bg-gradient-to-br from-blue-600 to-violet-600 h-screen flex items-center justify-center">
            <div class="flex items-center justify-center h-screen flex-col">
               <div class="flex p-10 bg-white rounded-lg flex-col mx-auto justify-center items-center">
               <div class="text-blue-600 text-4xl font-bold flex items-center">
                    <i class="fas fa-user-circle"></i>
                    <span class="ml-2">Welkom bij {{ config('app.name', 'Laravel') }}</span>
                </div>
                <div class="border-t border-gray-300 w-full mt-4"></div>
                <div class="flex gap-4 mt-4 flex-col text-center">
                    <a href="/join-quiz" class="px-8 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-lg text-lg font-semibold hover:bg-opacity-90 transition-colors">
                        Join Quiz
                    </a>
                    <a href="/teacher/login" class="px-8 py-3 bg-gradient-to-r from-green-500 to-blue-500 text-white rounded-lg text-lg font-semibold hover:bg-opacity-90 transition-colors">
                        Inloggen als docent
                    </a>
                    <a href="/admin/login" class="px-8 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg text-lg font-semibold hover:bg-opacity-90 transition-colors">
                        Inloggen als beheerder
                    </a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
