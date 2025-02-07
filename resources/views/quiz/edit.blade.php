@include('layouts.app')
@if(isset($error))
            <div class="text-red-500 text-center mb-4 italic break-words">{{ $error }}</div>
        @endif
        @if(isset($success))
            <div class="text-green-500 text-center mb-4 italic break-words">{{ $success }}</div>
        @endif
<div class="flex">
    <!-- Fixed Sidebar for Questions -->
    <div class="fixed left-0 top-0 h-screen w-full bg-gray-100 overflow-y-auto pt-16">
        <h2 class="text-xl font-bold mb-4 px-4">Questions</h2>
        <ul class="space-y-2">
            @if (empty($questions))
                <li class="p-2 bg-white shadow hover:bg-gray-50">
                    <div class="mb-2">
                        <span class="font-bold">No questions found</span>
                    </div>
                </li>
            @else
                @foreach($questions as $question)
                    <li class="p-2 bg-white shadow hover:bg-gray-50 cursor-pointer" onclick="openQuestionModal({{ json_encode($question) }})">
                    <div class="mb-2 flex flex-col">
                        <span class="font-bold">Question:</span>
                        <div class="flex justify-between items-center">
                            <span>{{ $question['question'] }}</span>
                            <div class="space-x-2">
                                
                            </div>
                        </div>
                    </div>
                    
                    @if($question['type'] === 'multiple choice')
                        <div class="ml-4">
                            <span class="font-semibold">Answers:</span>
                            <ul class="list-disc ml-4">
                            @foreach($question['answers'] as $answer)
                                <li class="{{ $answer['correct'] ? 'text-green-600' : '' }}">
                                    {{ $answer['answer'] }}
                                    @if($answer['correct'])
                                        <span class="text-xs">(correct)</span>
                                    @endif
                                </li>
                            @endforeach
                            </ul>
                        </div>
                    @else
                        <div class="ml-4">
                            <span class="font-semibold">Answer:</span>
                            <span class="text-green-600">{{ $question['answer']['answer'] }}</span>
                        </div>
                    @endif
                </li>
            @endforeach
            @endif
        </ul>
        <form action="{{ route('quiz.update', $quiz->id) }}" method="POST" class="w-full gap-4 flex flex-col mt-4">
                @csrf
                @method('PUT')
                <div class="flex items-center gap-2"> 
                <div class="flex items-center gap-3 flex-col  mx-auto">
                    <div class="relative flex flex-col">
                        <i class="border-r border-gray-300 pr-2 fa-solid fa-pencil absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                        <input class="w-full p-2 pl-10 rounded-md border-2 border-gray-300" type="text" name="name" placeholder="Quiz Name" value="{{ old('name', $quiz->name) }}">
                    </div>
                    <button class="w-full p-2 rounded-md bg-gradient-to-r from-orange-500 to-red-500 text-white font-bold" type="submit">Update name</button>
                </div>
                
            </form>
    </div>

    <!-- Question Edit Modal -->
    <div class="py-12 bg-gray-700 bg-opacity-50 transition duration-150 ease-in-out z-50 fixed top-0 right-0 bottom-0 left-0 hidden" id="questionModal">
        <div role="alert" class="container mx-auto w-11/12 md:w-2/3 max-w-lg">
            <div class="relative py-8 px-5 md:px-10 bg-white shadow-md rounded border border-gray-400">
                <h1 class="text-gray-800 font-lg font-bold tracking-normal leading-tight mb-4">Edit Question</h1>
                
                <label class="text-gray-800 text-sm font-bold leading-tight tracking-normal">Question Text</label>
                <input id="questionText" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border" />
                
                <label class="text-gray-800 text-sm font-bold leading-tight tracking-normal">Question Type</label>
                <select id="questionType" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                    <option value="multiple choice">Multiple Choice</option>
                    <option value="text">Text Answer</option>
                </select>

                <div id="answersContainer" class="mb-5">
                    <!-- Answers will be dynamically added here -->
                </div>

                <div class="flex items-center justify-start w-full">
                    <button onclick="saveQuestion()" class="focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 transition duration-150 ease-in-out hover:bg-indigo-600 bg-indigo-700 rounded text-white px-8 py-2 text-sm">Save</button>
                    <button class="focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 ml-3 bg-gray-100 transition duration-150 text-gray-600 ease-in-out hover:border-gray-400 hover:bg-gray-300 border rounded px-8 py-2 text-sm" onclick="closeQuestionModal()">Cancel</button>
                </div>

                <button class="cursor-pointer absolute top-0 right-0 mt-4 mr-5 text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out rounded focus:ring-2 focus:outline-none focus:ring-gray-600" onclick="closeQuestionModal()" aria-label="close modal">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" />
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="ml-1/4 flex-1 p-10">
        <!-- ... existing content ... -->
    </div>
</div>

<script>
    let questionModal = document.getElementById("questionModal");
    let currentQuestion = null;

    function openQuestionModal(question) {
        currentQuestion = question;
        document.getElementById('questionText').value = question.question;
        document.getElementById('questionType').value = question.type;
        updateAnswersContainer(question);
        fadeIn(questionModal);
    }

    function closeQuestionModal() {
        fadeOut(questionModal);
        currentQuestion = null;
    }

    function fadeOut(el) {
        el.style.opacity = 1;
        el.style.transform = 'scale(1)';
        (function fade() {
            if ((el.style.opacity -= 0.1) < 0) {
                el.style.display = "none";
                el.style.transform = 'scale(0.8)';
            } else {
                el.style.transform = `scale(${0.8 + parseFloat(el.style.opacity) * 0.2})`;
                requestAnimationFrame(fade);
            }
        })();
    }

    function fadeIn(el, display) {
        el.style.opacity = 0;
        el.style.transform = 'scale(0.8)';
        el.style.display = display || "flex";
        (function fade() {
            let val = parseFloat(el.style.opacity);
            if (!((val += 0.1) > 1)) {
                el.style.opacity = val;
                el.style.transform = `scale(${0.8 + val * 0.2})`;
                requestAnimationFrame(fade);
            }
        })();
    }

    function updateAnswersContainer(question) {
        const container = document.getElementById('answersContainer');
        container.innerHTML = ''; // Clear existing answers

        if (question.type === 'multiple choice') {
            // Add multiple choice answers interface
            question.answers.forEach((answer, index) => {
                container.innerHTML += `
                    <div class="flex items-center gap-2 mb-2">
                        <input type="text" value="${answer.answer}" class="flex-1 p-2 border rounded">
                        <input type="checkbox" ${answer.correct ? 'checked' : ''}>
                        <button onclick="removeAnswer(${index})" class="text-red-500">×</button>
                    </div>
                `;
            });
            container.innerHTML += `
                <button onclick="addAnswer()" class="text-blue-500 text-sm">+ Add Answer</button>
            `;
        } else {
            // Add text answer interface
            container.innerHTML = `
                <input type="text" value="${question.answer.answer}" class="w-full p-2 border rounded">
            `;
        }
    }

    function saveQuestion() {
        // Here you would implement the logic to save the question
        // You'll need to make an AJAX call to your backend
        closeQuestionModal();
    }
</script>