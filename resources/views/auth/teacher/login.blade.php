@include('layouts.app')

<div class="flex items-center justify-center h-screen flex-col">
                
        <div class="flex p-10 bg-white rounded-lg flex-col mx-auto justify-center items-center">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-14 mb-4 w-auto">
        <!-- use -->
        <div class="text-gray-800 text-4xl font-bold flex items-center mb-4">
            <span class="ml-2 font-bold">Inloggen als docent</span>
        </div>
        
        <form action="{{ route('check-code') }}" method="POST" class="w-full gap-4 flex flex-col">
        <div class="border-t border-gray-300 w-full mb-4 pt-4"></div>
            @csrf
            <!-- id icon fontawesome -->
            <div class="flex items-center gap-2"> 


            <div class="flex items-center gap-3">
                <div class="relative">
                    <i class="border-r border-gray-300 pr-2 fa-solid fa-key absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                    <input class="w-full p-2 pl-10 rounded-md border-2 border-gray-300" type="text" name="password" placeholder="Wachtwoord">
                </div>
            </div>
            </div>
            <button class="w-full p-2 rounded-md bg-gradient-to-r from-orange-500 to-red-500 text-white font-bold" type="submit">Inloggen</button>
            @if(isset($error))
            <div class="text-red-500 text-center mb-4 italic break-words">{{ $error }}</div>
        @endif
        @if(isset($success))
            <div class="text-green-500 text-center mb-4 italic break-words">{{ $success }}</div>
        @endif
        </form>

    </div>
        </div>
        <style>
            body {
                font-family: 'Poppins', sans-serif;
            }
        </style>