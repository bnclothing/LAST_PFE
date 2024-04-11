<div class="help-icon" onclick="toggleModal()">
    <i class="fa-solid fa-circle-info"></i>
</div>

<div id="myModal" class="modal-help">
    <div class="modal-content-help">
        <div>
            <h2 class="questions-label">Questions</h2>
            <div class="questions">
    
                <script>
                    questions.forEach(function(q) {
                        document.write('<p class="question" onclick="showAnswer(this)">' + q.question + '</p>');
                        document.write('<div class="answer">' + q.answer + '</div>');
                    });
                </script>
    
            </div>
        </div>
        <div class="search-bar">
            <input autocomplete="off" type="text" id="response-search" placeholder="Search...">
        </div>
    </div>
</div>