function toggleModal() {
    var myModal = document.getElementById("myModal");
    myModal.classList.toggle("show-help");
}

function showAnswer(question) {
    // Toggle the 'active' class on the clicked question
    question.classList.toggle('active');
}