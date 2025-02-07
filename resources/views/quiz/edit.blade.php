@include('layouts.app')
@section('content')
    @if(session('error'))
        <div class="text-red-500 text-center mb-4 italic break-words">
            {{ session('error') }}
        </div>
    @endif
    @if(session('success'))
        <div class="text-green-500 text-center mb-4 italic break-words">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('quiz.update', $quiz->id) }}" method="POST" id="quizForm" class="flex">
        @csrf
        @method('PUT')

        <!-- Hidden Input to Store Questions JSON -->
        <input type="hidden" name="questions" id="questionsInput" value="{{ json_encode($questions) }}">

        <!-- Sidebar Div for Questions -->
        <div class="w-1/3 p-4 bg-gray-100 rounded-lg mr-6 h-screen overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Questions</h2>
                <button type="button" onclick="openAddQuestionModal()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">
                    Add Question
                </button>
            </div>
            @if(count($questions) > 0)
                <ul class="space-y-2" id="questionsList">
                    @foreach($questions as $index => $question)
                        <li class="p-2 bg-white rounded shadow flex justify-between items-start">
                            <div>
                                <div class="mb-2">
                                    <span class="font-bold">Q{{ $index + 1 }}:</span> {{ $question['question'] }}
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
                            </div>
                            <div class="flex flex-col space-y-2">
                                <button type="button" onclick="openEditQuestionModal({{ $index }})" class="text-blue-500 hover:underline">Edit</button>
                                <button type="button" onclick="deleteQuestion({{ $index }})" class="text-red-500 hover:underline">Delete</button>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="text-gray-500 italic">
                    No questions available. Click "Add Question" to create one.
                </div>
            @endif
        </div>

        <!-- Main Edit Form -->
        <div class="flex-1 p-10 bg-white rounded-lg">
            <div class="text-gray-800 text-4xl font-bold flex items-center mb-6">
                <span class="ml-2">Edit Quiz: '{{ $quiz->name }}'</span>
            </div>

            <div class="flex items-center gap-4"> 
                <div class="flex-1">
                    <label for="name" class="block text-gray-700 font-bold mb-2">Quiz Name:</label>
                    <input 
                        id="name" 
                        class="w-full p-2 pl-3 rounded-md border-2 border-gray-300" 
                        type="text" 
                        name="name" 
                        placeholder="Quiz Name" 
                        value="{{ old('name', $quiz->name) }}" 
                        required
                    >
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <button class="py-2 px-4 rounded-md bg-gradient-to-r from-orange-500 to-red-500 text-white font-bold hover:from-orange-600 hover:to-red-600" type="submit">
                        Update Quiz
                    </button>
                </div>
            </div>
        </div>
    </form>

    <!-- Add/Edit Question Modal -->
    <div class="fixed inset-0 bg-gray-700 bg-opacity-50 flex items-center justify-center hidden" id="questionModal">
        <div class="bg-white rounded-lg w-11/12 md:w-2/3 lg:w-1/2 p-6 relative">
            <h2 class="text-2xl font-bold mb-4" id="modalTitle">Add Question</h2>
            
            <form id="questionForm">
                @csrf
                <input type="hidden" id="questionIndex" value="">
                
                <div class="mb-4">
                    <label for="questionText" class="block text-gray-700 font-bold mb-2">Question Text:</label>
                    <textarea id="questionText" class="w-full p-2 border rounded" rows="3" required></textarea>
                </div>

                <div class="mb-4">
                    <label for="questionType" class="block text-gray-700 font-bold mb-2">Question Type:</label>
                    <select id="questionType" class="w-full p-2 border rounded" required onchange="toggleAnswerFields()">
                        <option value="multiple choice">Multiple Choice</option>
                        <option value="short answer">Short Answer</option>
                    </select>
                </div>

                <div id="multipleChoiceSection" class="mb-4 hidden">
                    <label class="block text-gray-700 font-bold mb-2">Answers:</label>
                    <div id="answersContainer" class="space-y-2">
                        <!-- Existing answers will be injected here -->
                    </div>
                    <button type="button" onclick="addAnswerField()" class="mt-2 bg-green-500 hover:bg-green-700 text-white py-1 px-3 rounded">Add Answer</button>
                </div>

                <div id="shortAnswerSection" class="mb-4 hidden">
                    <label for="shortAnswer" class="block text-gray-700 font-bold mb-2">Answer:</label>
                    <input type="text" id="shortAnswer" class="w-full p-2 border rounded" required>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeQuestionModal()" class="bg-gray-500 hover:bg-gray-700 text-white py-2 px-4 rounded">Cancel</button>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded" id="saveQuestionButton">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Initialize questions data
        let questionsData = {!! json_encode($questions) !!};
        document.getElementById('questionsInput').value = JSON.stringify(questionsData);

        // Function to open the Add Question modal
        function openAddQuestionModal() {
            document.getElementById('modalTitle').textContent = 'Add Question';
            document.getElementById('questionIndex').value = '';
            document.getElementById('questionText').value = '';
            document.getElementById('questionType').value = 'multiple choice';
            toggleAnswerFields();

            // Clear existing answers
            const answersContainer = document.getElementById('answersContainer');
            answersContainer.innerHTML = '';
            addAnswerField();
            addAnswerField();

            // Show the modal
            document.getElementById('questionModal').classList.remove('hidden');
        }

        // Function to open the Edit Question modal
        function openEditQuestionModal(index) {
            const question = questionsData[index];
            document.getElementById('modalTitle').textContent = 'Edit Question';
            document.getElementById('questionIndex').value = index;
            document.getElementById('questionText').value = question['question'];
            document.getElementById('questionType').value = question['type'];
            toggleAnswerFields();

            const answersContainer = document.getElementById('answersContainer');
            answersContainer.innerHTML = '';

            if (question['type'] === 'multiple choice') {
                question['answers'].forEach((answer, idx) => {
                    addAnswerField(answer['answer'], answer['correct']);
                });
            } else {
                document.getElementById('shortAnswer').value = question['answer']['answer'];
            }

            // Show the modal
            document.getElementById('questionModal').classList.remove('hidden');
        }

        // Function to close the Question modal
        function closeQuestionModal() {
            document.getElementById('questionModal').classList.add('hidden');
        }

        // Function to toggle answer fields based on question type
        function toggleAnswerFields() {
            const type = document.getElementById('questionType').value;
            if (type === 'multiple choice') {
                document.getElementById('multipleChoiceSection').classList.remove('hidden');
                document.getElementById('shortAnswerSection').classList.add('hidden');
            } else {
                document.getElementById('multipleChoiceSection').classList.add('hidden');
                document.getElementById('shortAnswerSection').classList.remove('hidden');
            }
        }

        // Function to add an answer field
        function addAnswerField(answerText = '', isCorrect = false) {
            const answersContainer = document.getElementById('answersContainer');
            const answerDiv = document.createElement('div');
            answerDiv.className = 'flex items-center space-x-2';

            answerDiv.innerHTML = `
                <input type="text" class="w-full p-2 border rounded" placeholder="Answer" value="${answerText}" required>
                <label class="flex items-center space-x-1">
                    <input type="checkbox" class="correct-checkbox" ${isCorrect ? 'checked' : ''}>
                    <span>Correct</span>
                </label>
                <button type="button" onclick="removeAnswerField(this)" class="text-red-500">Remove</button>
            `;

            answersContainer.appendChild(answerDiv);
        }

        // Function to remove an answer field
        function removeAnswerField(button) {
            button.parentElement.remove();
        }

        // Handle form submission for adding/editing a question
        document.getElementById('questionForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const index = document.getElementById('questionIndex').value;
            const questionText = document.getElementById('questionText').value.trim();
            const questionType = document.getElementById('questionType').value;

            if (questionType === 'multiple choice') {
                const answersElements = document.querySelectorAll('#answersContainer > div');
                const answers = [];

                answersElements.forEach(div => {
                    const answerText = div.querySelector('input[type="text"]').value.trim();
                    const isCorrect = div.querySelector('.correct-checkbox').checked;

                    if (answerText !== '') {
                        answers.push({
                            answer: answerText,
                            correct: isCorrect
                        });
                    }
                });

                if (answers.length < 2) {
                    alert('Please provide at least two answers for multiple choice questions.');
                    return;
                }

                const correctAnswers = answers.filter(a => a.correct);
                if (correctAnswers.length === 0) {
                    alert('Please mark at least one correct answer.');
                    return;
                }

                const newQuestion = {
                    type: 'multiple choice',
                    question: questionText,
                    answers: answers
                };

                if (index === '') {
                    // Add new question
                    questionsData.push(newQuestion);
                } else {
                    // Edit existing question
                    questionsData[index] = newQuestion;
                }
            } else {
                const shortAnswer = document.getElementById('shortAnswer').value.trim();
                if (shortAnswer === '') {
                    alert('Please provide an answer for short answer questions.');
                    return;
                }

                const newQuestion = {
                    type: 'short answer',
                    question: questionText,
                    answer: {
                        answer: shortAnswer,
                        correct: true // Assuming correct is always true for open questions
                    }
                };

                if (index === '') {
                    // Add new question
                    questionsData.push(newQuestion);
                } else {
                    // Edit existing question
                    questionsData[index] = newQuestion;
                }
            }

            // Update the hidden input
            document.getElementById('questionsInput').value = JSON.stringify(questionsData);

            // Update the questions list in the sidebar
            updateQuestionsList();

            // Close the modal
            closeQuestionModal();
        });

        // Function to update the questions list display
        function updateQuestionsList() {
            const questionsList = document.getElementById('questionsList');
            questionsList.innerHTML = '';

            if (questionsData.length === 0) {
                questionsList.innerHTML = `
                    <li class="p-2 bg-white shadow hover:bg-gray-50">
                        <div class="mb-2">
                            <span class="font-bold">No questions found</span>
                        </div>
                    </li>
                `;
                return;
            }

            questionsData.forEach((question, index) => {
                const li = document.createElement('li');
                li.className = "p-2 bg-white rounded shadow flex justify-between items-start";

                const contentDiv = document.createElement('div');

                const questionDiv = document.createElement('div');
                questionDiv.className = "mb-2";
                questionDiv.innerHTML = `<span class="font-bold">Q${index + 1}:</span> ${question.question}`;
                contentDiv.appendChild(questionDiv);

                if (question.type === 'multiple choice') {
                    const answersDiv = document.createElement('div');
                    answersDiv.className = "ml-4";
                    answersDiv.innerHTML = '<span class="font-semibold">Answers:</span>';

                    const answersList = document.createElement('ul');
                    answersList.className = "list-disc ml-4";
                    question.answers.forEach(answer => {
                        const answerLi = document.createElement('li');
                        answerLi.className = answer.correct ? 'text-green-600' : '';
                        answerLi.textContent = answer.answer;
                        if (answer.correct) {
                            const correctSpan = document.createElement('span');
                            correctSpan.className = 'text-xs';
                            correctSpan.textContent = ' (correct)';
                            answerLi.appendChild(correctSpan);
                        }
                        answersList.appendChild(answerLi);
                    });
                    answersDiv.appendChild(answersList);
                    contentDiv.appendChild(answersDiv);
                } else {
                    const answerDiv = document.createElement('div');
                    answerDiv.className = "ml-4";
                    answerDiv.innerHTML = `<span class="font-semibold">Answer:</span> <span class="text-green-600">${question.answer.answer}</span>`;
                    contentDiv.appendChild(answerDiv);
                }

                li.appendChild(contentDiv);

                const actionsDiv = document.createElement('div');
                actionsDiv.className = "flex flex-col space-y-2";

                const editButton = document.createElement('button');
                editButton.type = 'button';
                editButton.className = "text-blue-500 hover:underline";
                editButton.textContent = 'Edit';
                editButton.onclick = () => openEditQuestionModal(index);
                actionsDiv.appendChild(editButton);

                const deleteButton = document.createElement('button');
                deleteButton.type = 'button';
                deleteButton.className = "text-red-500 hover:underline";
                deleteButton.textContent = 'Delete';
                deleteButton.onclick = () => deleteQuestion(index);
                actionsDiv.appendChild(deleteButton);

                li.appendChild(actionsDiv);

                questionsList.appendChild(li);
            });
        }

        // Function to delete a question
        function deleteQuestion(index) {
            if (confirm('Are you sure you want to delete this question?')) {
                questionsData.splice(index, 1);
                document.getElementById('questionsInput').value = JSON.stringify(questionsData);
                updateQuestionsList();
            }
        }

        // Initialize the questions list on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateQuestionsList();
        });
    </script>