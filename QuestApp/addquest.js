document.getElementById('addquestion').addEventListener('click', function() {

    const questionInput = document.getElementById('quest1').value;
    const answers = [
        document.getElementById('a1').value,
        document.getElementById('a2').value,
        document.getElementById('a3').value,
        document.getElementById('a4').value
    ];


    const correctAnswer = document.getElementById('correct-answer').value;
    const correctAnswerIndex = ['a1', 'a2', 'a3', 'a4'].indexOf(correctAnswer);


    const difficulty = parseInt(document.getElementById('difficulty').value);


    const questionObj = { 
        question: questionInput, 
        answers: answers, 
        correctAnswer: correctAnswerIndex, 
        difficulty: difficulty 
    };

    
    let questions = JSON.parse(localStorage.getItem('questions')) || [];
    questions.push(questionObj);


    localStorage.setItem('questions', JSON.stringify(questions));


    alert('Soru Eklendi!');
    window.location.href = 'quests.html';
});
