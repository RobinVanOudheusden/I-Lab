<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body>
        <div class="bg-gradient-to-br from-blue-600 to-violet-600">
            <div class="flex items-center justify-center h-screen">
                <div class="text-white text-4xl font-bold">
                    <i class="fas fa-user-circle"></i>
                    <span class="ml-2">Welkom bij {{ config('app.name', 'Laravel') }}</span>
                </div>
                <div class="fixed bottom-10 flex gap-6">
                    <a href="/join-quiz" class="px-8 py-3 bg-white text-blue-600 rounded-lg text-lg font-semibold hover:bg-opacity-90 transition-colors">
                        Join Quiz
                    </a>
                    <a href="/teacher/login" class="px-8 py-3 bg-transparent border-2 border-white text-white rounded-lg text-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors">
                        Teacher Login
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>
