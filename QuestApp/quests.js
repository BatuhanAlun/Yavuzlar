document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const difficultySelect = document.getElementById('difficulty-select');
    const questionsContainer = document.getElementById('questions-container');
    const takeQuizButton = document.getElementById('takequizpage');
    let questions = JSON.parse(localStorage.getItem('questions')) || [];

    function displayQuestions(filteredQuestions) {
        questionsContainer.innerHTML = '';
        filteredQuestions.forEach(function(questionObj, index) {
            const questionDiv = document.createElement("div");
            questionDiv.classList.add("questions");

            const questionTitle = document.createElement("p");
            questionTitle.textContent = questionObj.question;
            questionDiv.appendChild(questionTitle);

            const buttonsDiv = document.createElement("div");
            buttonsDiv.classList.add("question-buttons");

            const editButton = document.createElement("button");
            editButton.textContent = "Düzenle";
            editButton.classList.add("edit-button");
            editButton.addEventListener('click', function() {
                window.location.href = `edit.html?index=${index}`;
            });

            const deleteButton = document.createElement("button");
            deleteButton.textContent = "Sil";
            deleteButton.classList.add("delete-button");
            deleteButton.addEventListener('click', function() {
                questions.splice(index, 1);
                localStorage.setItem('questions', JSON.stringify(questions));
                displayQuestions(questions);
            });

            buttonsDiv.appendChild(editButton);
            buttonsDiv.appendChild(deleteButton);

            questionDiv.appendChild(buttonsDiv);
            questionsContainer.appendChild(questionDiv);
        });
    }

    function filterQuestions() {
        const query = searchInput.value.toLowerCase();
        const selectedDifficulty = difficultySelect.value;

        const filtered = questions.filter(q => {
            const matchesSearch = q.question.toLowerCase().includes(query);
            const matchesDifficulty = selectedDifficulty === '' || q.difficulty == selectedDifficulty;
            return matchesSearch && matchesDifficulty;
        });

        displayQuestions(filtered);
    }

    
    takeQuizButton.addEventListener('click', function() {
        const selectedDifficulty = difficultySelect.value;
        localStorage.setItem('selectedDifficulty', selectedDifficulty);
        window.location.href = 'takequiz.html';
    });

    displayQuestions(questions);

    searchInput.addEventListener('input', filterQuestions);
    difficultySelect.addEventListener('change', filterQuestions);
});
