let currentQuestionIndex = 0;
let score = 0;
let questions = JSON.parse(localStorage.getItem('questions')) || [];
const selectedDifficulty = localStorage.getItem('selectedDifficulty');


if (selectedDifficulty !== '') {
    questions = questions.filter(q => q.difficulty == selectedDifficulty);
}

function shuffleArray(array) {
    for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
}

shuffleArray(questions);

function loadQuestion(index) {
    if (index >= questions.length) {
        localStorage.setItem('score', score);
        window.location.href = 'skorboard.html';
        return;
    }

    const questionObj = questions[index];
    document.getElementById('question').textContent = questionObj.question;
    const answersContainer = document.getElementById('answers');
    answersContainer.innerHTML = '';

    questionObj.answers.forEach((answer, i) => {
        const button = document.createElement('button');
        button.textContent = answer;
        button.classList.add('answer-button');
        button.dataset.index = i;
        button.addEventListener('click', function() {
            handleAnswer(button);
        });
        answersContainer.appendChild(button);
    });
}

function handleAnswer(selectedButton) {
    const correctIndex = questions[currentQuestionIndex].correctAnswer;
    const buttons = document.querySelectorAll('.answer-button');
    
    buttons.forEach(button => {
        if (button.dataset.index == correctIndex) {
            button.classList.add('correct');
        } else {
            button.classList.add('incorrect');
        }
        button.disabled = true;
    });

    if (selectedButton.dataset.index == correctIndex) {
        selectedButton.classList.add('correct');
        score += 5; 
    } else {
        selectedButton.classList.add('incorrect');
        score -= 1; 
    }

    document.getElementById('next-button').disabled = false;
}

document.getElementById('next-button').addEventListener('click', function() {
    currentQuestionIndex++;
    loadQuestion(currentQuestionIndex);
    this.disabled = true;
});

loadQuestion(currentQuestionIndex);
