document.addEventListener('DOMContentLoaded', function() {
            
    const urlParams = new URLSearchParams(window.location.search);
    const questionIndex = parseInt(urlParams.get('index'));

    if (isNaN(questionIndex)) {
        alert('Geçersiz soru indeks!');
        return;
    }

    
    const questions = JSON.parse(localStorage.getItem('questions')) || [];

    
    const questionObj = questions[questionIndex];

    if (!questionObj) {
        alert('Soru bulunamadı!');
        return;
    }

    
    document.getElementById('quest1').value = questionObj.question;
    document.getElementById('a1').value = questionObj.answers[0] || '';
    document.getElementById('a2').value = questionObj.answers[1] || '';
    document.getElementById('a3').value = questionObj.answers[2] || '';
    document.getElementById('a4').value = questionObj.answers[3] || '';

    document.getElementById('updatequestion').addEventListener('click', function() {
        
        const updatedQuestion = document.getElementById('quest1').value;
        const updatedAnswers = [
            document.getElementById('a1').value,
            document.getElementById('a2').value,
            document.getElementById('a3').value,
            document.getElementById('a4').value
        ];

        
        questions[questionIndex] = { question: updatedQuestion, answers: updatedAnswers };
        localStorage.setItem('questions', JSON.stringify(questions));

        alert('Soru Güncellendi!');
        window.location.href = 'quests.html';
    });
});