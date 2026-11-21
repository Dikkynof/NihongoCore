(() => {
  "use strict";

  const elements = {
    quiz: document.getElementById("quiz-section"),
    result: document.getElementById("result-section"),
    word: document.getElementById("word"),
    reading: document.getElementById("reading"),
    chapter: document.getElementById("chapter"),
    questionIndex: document.getElementById("question-index"),
    options: document.getElementById("options"),
    feedback: document.getElementById("feedback"),
    countdownBar: document.getElementById("countdown-bar"),
    progress: document.getElementById("progress"),
    progressText: document.getElementById("progress-text"),
    total: document.getElementById("total-question"),
    correct: document.getElementById("correct-count"),
    wrong: document.getElementById("wrong-count"),
    finalScore: document.getElementById("final-score"),
    finalMessage: document.getElementById("final-message"),
    restart: document.getElementById("restart")
  };

  let questions = [];
  let currentQuestion = 0;
  let correctAnswers = 0;
  let wrongAnswers = 0;
  let answered = false;
  let nextQuestionTimeout;
  const NEXT_QUESTION_DELAY_MS = 3000;

  function shuffle(items) {
    const result = [...items];
    for (let i = result.length - 1; i > 0; i -= 1) {
      const j = Math.floor(Math.random() * (i + 1));
      [result[i], result[j]] = [result[j], result[i]];
    }
    return result;
  }

  function updateProgress() {
    const percent = Math.round((currentQuestion / questions.length) * 100);
    elements.total.textContent = String(Math.min(currentQuestion + 1, questions.length));
    elements.correct.textContent = String(correctAnswers);
    elements.wrong.textContent = String(wrongAnswers);
    elements.questionIndex.textContent = `${currentQuestion + 1}/${questions.length}`;
    elements.progress.style.width = `${percent}%`;
    elements.progressText.textContent = `${percent}%`;
  }

  function showQuestion() {
    answered = false;
    const question = questions[currentQuestion];
    updateProgress();
    elements.word.textContent = question.word;
    elements.reading.textContent = question.reading;
    elements.chapter.textContent = question.category;
    elements.feedback.textContent = "";
    elements.feedback.className = "feedback";
    elements.countdownBar.style.width = "0%";
    elements.options.replaceChildren();

    question.options.forEach((option) => {
      const button = document.createElement("button");
      button.type = "button";
      button.className = "answer-btn";
      button.textContent = option[2];
      button.addEventListener("click", () => checkAnswer(option, button));
      elements.options.append(button);
    });
  }

  function checkAnswer(selected, selectedButton) {
    if (answered) return;
    answered = true;
    const question = questions[currentQuestion];
    const buttons = [...elements.options.querySelectorAll(".answer-btn")];
    buttons.forEach((button) => { button.disabled = true; });

    if (selected[2] === question.meaning) {
      correctAnswers += 1;
      selectedButton.classList.add("correct");
      elements.feedback.textContent = "✓ Benar! 正解です！";
      elements.feedback.classList.add("correct-text");
    } else {
      wrongAnswers += 1;
      selectedButton.classList.add("wrong");
      const correctButton = buttons.find((button) => button.textContent === question.meaning);
      if (correctButton) correctButton.classList.add("correct");
      elements.feedback.textContent = `✕ Kurang tepat! Jawaban: ${question.meaning}`;
      elements.feedback.classList.add("wrong-text");
    }

    elements.correct.textContent = String(correctAnswers);
    elements.wrong.textContent = String(wrongAnswers);
    elements.countdownBar.style.width = "100%";
    nextQuestionTimeout = window.setTimeout(nextQuestion, NEXT_QUESTION_DELAY_MS);
  }

  function finishQuiz() {
    elements.quiz.classList.add("d-none");
    elements.result.classList.remove("d-none");
    elements.progress.style.width = "100%";
    elements.progressText.textContent = "100%";
    elements.total.textContent = String(questions.length);
    const percentage = Math.round((correctAnswers / questions.length) * 100);
    elements.finalScore.textContent = `Skor kamu: ${correctAnswers}/${questions.length} (${percentage}%)`;

    if (percentage === 100) {
      elements.finalMessage.textContent = "Sempurna! Semua jawaban benar!";
    } else if (percentage >= 80) {
      elements.finalMessage.textContent = "Bagus! Penguasaan kotoba kamu sudah sangat baik.";
    } else if (percentage >= 50) {
      elements.finalMessage.textContent = "Lumayan! Terus tingkatkan kemampuan kosakatamu.";
    } else {
      elements.finalMessage.textContent = "Tetap semangat! Coba pelajari kembali kosakatanya.";
    }
  }

  function nextQuestion() {
    window.clearTimeout(nextQuestionTimeout);
    currentQuestion += 1;
    if (currentQuestion < questions.length) showQuestion();
    else finishQuiz();
  }

  function restartQuiz() {
    window.clearTimeout(nextQuestionTimeout);
    if (!Array.isArray(window.vocabulary) || window.vocabulary.length < 4) {
      elements.quiz.innerHTML = "<p class=\"text-danger text-center\">Database kosakata tidak mencukupi.</p>";
      return;
    }

    questions = shuffle(window.vocabulary).map((item) => {
      const distractors = shuffle(window.vocabulary.filter((entry) => entry[2] !== item[2])).slice(0, 3);
      return {
        word: item[0],
        reading: item[1],
        meaning: item[2],
        category: item[3],
        options: shuffle([item, ...distractors])
      };
    });
    currentQuestion = 0;
    correctAnswers = 0;
    wrongAnswers = 0;
    elements.quiz.classList.remove("d-none");
    elements.result.classList.add("d-none");
    showQuestion();
  }

  elements.restart.addEventListener("click", restartQuiz);
  restartQuiz();
})();
