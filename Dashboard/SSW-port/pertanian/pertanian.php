<?php
$vocabulary = include(__DIR__ . '/vocabulary_prt.php');

$vocabularyJson = json_encode(
    $vocabulary,
    JSON_UNESCAPED_UNICODE |
        JSON_HEX_TAG |
        JSON_HEX_APOS |
        JSON_HEX_QUOT |
        JSON_HEX_AMP
);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nihon Go - Kotoba Quiz</title>

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        :root {
            --background: #0b0a12;
            --card: #1b1b29;
            --border: #333345;
            --purple: #9483ff;
            --purple-light: #b28aff;
            --text: #e9e9ff;
            --muted: #737489;
            --green: #42d4a6;
            --red: #f07883;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background:
                radial-gradient(circle at top left, #291321 0%, transparent 35%),
                var(--background);

            color: var(--text);
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            padding-bottom: 40px;
        }

        /* HEADER */

        .header {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(12, 11, 19, .95);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid #39202f;
            padding: 17px 20px;
        }

        .brand-icon {
            width: 48px;
            height: 48px;
            border: 1px solid #bd4269;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
        }

        .brand-title {
            font-family: 'Noto Sans JP', sans-serif;
            font-weight: 800;
            font-size: 18px;
        }

        .brand-subtitle {
            color: #85869b;
            font-size: 9px;
            letter-spacing: 1.5px;
            font-weight: 800;
        }

        .brand-badge {
            background: #ffc2d1;
            color: #381b29;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 800;
        }

        /* MAIN */

        .container-main {
            max-width: 720px;
            margin: auto;
            padding: 25px 18px;
        }

        /* STATISTICS */

        .stat-card {
            position: relative;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 19px;
            padding: 19px 10px;
            text-align: center;
            overflow: hidden;
            min-height: 110px;
        }

        .stat-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg,
                    var(--purple),
                    var(--purple-light));
        }

        .stat-label {
            font-size: 13px;
            font-weight: 800;
            color: #74758b;
        }

        .stat-number {
            font-family: 'Noto Sans JP', sans-serif;
            font-size: 29px;
            font-weight: 800;
            margin-top: 5px;
        }

        /* PROGRESS */

        .progress {
            height: 8px;
            background: #242332;
            border-radius: 20px;
        }

        .progress-bar {
            background: linear-gradient(90deg,
                    var(--purple),
                    var(--purple-light));
            border-radius: 20px;
            transition: width .3s ease;
        }

        /* QUIZ CARD */

        .quiz-card {
            position: relative;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 34px;
            padding: 35px 25px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0, 0, 0, .25);
        }

        .quiz-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(90deg,
                    var(--purple),
                    var(--purple-light));
        }

        .badge-chapter {
            background: #303040;
            color: #bdbdcc;
            padding: 8px 15px;
            border-radius: 30px;
            font-weight: 500;
            font-size: 12px;
        }

        .badge-category {
            background: #202e4a;
            color: #a8c7ff;
            padding: 8px 15px;
            border-radius: 30px;
            font-size: 12px;
        }

        .question-index {
            color: #85859b;
            font-family: 'Noto Sans JP', sans-serif;
            font-size: 13px;
        }

        /* JAPANESE WORD */

        .question-word {
            margin-top: 65px;
            margin-bottom: 12px;
            text-align: center;
            font-family: 'Noto Sans JP', sans-serif;
            font-size: clamp(38px, 8vw, 65px);
            font-weight: 800;
            overflow-wrap: anywhere;
            line-height: 1.5;
        }

        .question-reading {
            text-align: center;
            color: #aaaabe;
            font-family: 'Noto Sans JP', sans-serif;
            font-size: 19px;
        }

        .divider {
            height: 1px;
            background: #303040;
            margin: 35px 0 20px;
        }

        .question-description {
            color: #77788e;
            text-align: center;
            font-size: 14px;
            margin-bottom: 22px;
        }

        /* ANSWER OPTIONS */

        .answer-btn {
            width: 100%;
            min-height: 75px;
            background: transparent;
            border: 2px solid #343447;
            border-radius: 17px;
            color: #dedeea;
            margin-bottom: 12px;
            padding: 15px;
            font-size: 15px;
            font-weight: 700;
            transition: .2s;
        }

        .answer-btn:hover:not(:disabled) {
            border-color: var(--purple);
            background: #252438;
            transform: translateY(-2px);
        }

        .answer-btn:disabled {
            opacity: 1;
            cursor: default;
        }

        .answer-btn.correct {
            background: rgba(42, 195, 147, .15);
            border-color: var(--green);
            color: var(--green);
        }

        .answer-btn.wrong {
            background: rgba(240, 120, 131, .13);
            border-color: var(--red);
            color: #ff9da5;
        }

        /* FEEDBACK */

        .feedback {
            text-align: center;
            min-height: 25px;
            margin-top: 10px;
            font-weight: 800;
            font-size: 14px;
        }

        .feedback.correct-text {
            color: var(--green);
        }

        .feedback.wrong-text {
            color: var(--red);
        }

        /* COUNTDOWN */

        .countdown {
            text-align: center;
            margin-top: 15px;
            color: #aaaabe;
            font-size: 12px;
        }

        .countdown-track {
            height: 5px;
            background: #303040;
            border-radius: 20px;
            overflow: hidden;
            margin-top: 9px;
        }

        .countdown-bar {
            height: 100%;
            width: 0%;
            background: #e6b35d;
            transition: width 1s linear;
        }

        /* RESULT */

        .result-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 30px;
            padding: 45px 25px;
            text-align: center;
        }

        .result-title {
            font-family: 'Noto Sans JP', sans-serif;
            font-size: 35px;
            color: var(--purple);
        }

        .restart-btn {
            background: var(--purple);
            color: #171321;
            border: none;
            border-radius: 12px;
            padding: 13px 25px;
            font-weight: 800;
        }

        .restart-btn:hover {
            background: var(--purple-light);
        }

        /* RESPONSIVE */

        @media(max-width: 576px) {

            .container-main {
                padding: 20px 13px;
            }

            .quiz-card {
                padding: 30px 20px;
                border-radius: 29px;
            }

            .question-word {
                margin-top: 45px;
            }

            .stat-card {
                min-height: 100px;
            }

        }


        /* =====================================
           NEON RED & BLUE THEME
        ===================================== */
        :root {
            --background: #070b18;
            --card: #10182b;
            --border: rgba(70, 130, 255, .28);
            --purple: #268cff;
            --purple-light: #ff315f;
            --text: #edf4ff;
            --muted: #8798b8;
            --green: #43f5b0;
            --red: #ff416c;
            --neon-blue: #268cff;
            --neon-red: #ff315f;
        }

        body {
            background:
                radial-gradient(ellipse at 8% 5%, rgba(28, 105, 255, .24), transparent 34%),
                radial-gradient(ellipse at 95% 18%, rgba(255, 35, 91, .18), transparent 32%),
                linear-gradient(145deg, #070b18 0%, #0a1020 55%, #100b1b 100%);
            background-attachment: fixed;
        }

        .header {
            background: rgba(6, 10, 23, .88);
            border-bottom: 1px solid rgba(45, 130, 255, .3);
            box-shadow: 0 5px 28px rgba(0, 102, 255, .09);
        }

        .brand-icon {
            border-color: rgba(255, 49, 95, .8);
            background: rgba(255, 49, 95, .09);
            box-shadow: 0 0 18px rgba(255, 49, 95, .22), inset 0 0 14px rgba(255, 49, 95, .1);
        }

        .brand-title {
            color: #f3f7ff;
        }

        .brand-subtitle {
            color: #8194ba;
        }

        .brand-badge {
            color: #fff;
            background: linear-gradient(100deg, #176cff, #fa315f);
            box-shadow: 0 0 15px rgba(255, 49, 95, .28);
        }

        .container-main {
            max-width: 1120px;
            padding-top: 34px;
        }

        .quiz-card,
        .result-card,
        .side-panel {
            background: linear-gradient(155deg, rgba(17, 27, 49, .98), rgba(12, 16, 33, .98));
            border: 1px solid rgba(65, 130, 255, .32);
            box-shadow: 0 0 0 1px rgba(255, 49, 95, .05),
                0 18px 50px rgba(0, 0, 0, .36),
                0 0 28px rgba(29, 111, 255, .11);
        }

        .quiz-card {
            border-radius: 28px;
            padding: 32px 28px;
        }

        .quiz-card::before {
            height: 3px;
            background: linear-gradient(90deg, #268cff, #a43cff, #ff315f);
            box-shadow: 0 0 18px rgba(38, 140, 255, .75);
        }

        .badge-chapter {
            background: rgba(38, 140, 255, .13);
            color: #8ec5ff;
            border: 1px solid rgba(38, 140, 255, .25);
        }

        .badge-category {
            background: rgba(255, 49, 95, .1);
            color: #ff8da8;
            border: 1px solid rgba(255, 49, 95, .22);
        }

        .question-index {
            color: #91a4c8;
        }

        .question-word {
            color: #f4f8ff;
            text-shadow: 0 0 18px rgba(38, 140, 255, .32);
        }

        .question-reading {
            color: #9bb4dc;
        }

        .divider {
            background: linear-gradient(90deg, transparent, rgba(77, 139, 255, .45), transparent);
        }

        .question-description {
            color: #8c9dbc;
        }

        .answer-btn {
            background: rgba(255, 255, 255, .025);
            border: 1px solid rgba(120, 149, 197, .22);
            border-radius: 15px;
            color: #dce8ff;
            min-height: 66px;
            text-align: left;
            padding: 16px 20px;
        }

        .answer-btn:hover:not(:disabled) {
            border-color: var(--neon-blue);
            background: rgba(38, 140, 255, .09);
            box-shadow: 0 0 17px rgba(38, 140, 255, .16);
        }

        .answer-btn.correct {
            color: #68ffc2;
            border-color: var(--green);
            background: rgba(67, 245, 176, .1);
            box-shadow: 0 0 16px rgba(67, 245, 176, .13);
        }

        .answer-btn.wrong {
            color: #ff8da8;
            border-color: var(--red);
            background: rgba(255, 49, 95, .1);
            box-shadow: 0 0 16px rgba(255, 49, 95, .13);
        }

        .feedback.correct-text {
            color: #68ffc2;
        }

        .feedback.wrong-text {
            color: #ff7898;
        }

        .progress {
            background: rgba(120, 149, 197, .13);
            height: 7px;
        }

        .progress-bar {
            background: linear-gradient(90deg, #268cff, #a43cff, #ff315f);
            box-shadow: 0 0 12px rgba(38, 140, 255, .6);
        }

        .quiz-sidebar {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .side-panel {
            border-radius: 22px;
            padding: 22px;
        }

        .side-panel-heading {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #a9c5ef;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.6px;
            margin-bottom: 18px;
        }

        .side-icon {
            color: #62b4ff;
            font-size: 20px;
            text-shadow: 0 0 12px rgba(38, 140, 255, .8);
        }

        .timer-value {
            color: #f4f8ff;
            font-family: 'Noto Sans JP', sans-serif;
            font-size: 38px;
            line-height: 1.2;
            font-weight: 800;
            text-shadow: 0 0 18px rgba(38, 140, 255, .45);
        }

        .side-hint {
            color: #7185aa;
            font-size: 11px;
            margin: 12px 0 0;
        }

        .countdown {
            margin-top: 15px;
            color: #ff9bb1;
            font-size: 12px;
            text-align: left;
        }

        .countdown-track {
            background: rgba(255, 255, 255, .1);
        }

        .countdown-bar {
            background: linear-gradient(90deg, #268cff, #ff315f);
            box-shadow: 0 0 12px rgba(255, 49, 95, .55);
        }

        .statistics-panel .stat-card {
            min-height: 100px;
            padding: 17px 12px;
            margin-bottom: 13px;
            border-radius: 15px;
            background: rgba(5, 12, 28, .55);
            border: 1px solid rgba(83, 133, 220, .22);
        }

        .statistics-panel .stat-card::before {
            height: 2px;
            background: linear-gradient(90deg, #268cff, #ff315f);
        }

        .stat-label {
            color: #8298bf;
            font-size: 10px;
            letter-spacing: 1px;
        }

        .stat-number {
            color: #eaf3ff;
        }

        #correct-count {
            color: #43f5b0 !important;
        }

        #wrong-count {
            color: #ff6688 !important;
        }

        .result-title {
            color: #64b4ff;
            text-shadow: 0 0 18px rgba(38, 140, 255, .45);
        }

        .restart-btn {
            color: #fff;
            background: linear-gradient(100deg, #176cff, #ef315f);
            box-shadow: 0 0 20px rgba(38, 140, 255, .25);
        }

        .restart-btn:hover {
            color: #fff;
            filter: brightness(1.15);
        }

        @media (max-width: 991.98px) {
            .container-main {
                max-width: 720px;
            }

            .quiz-sidebar {
                margin-top: 0;
            }

            .statistics-panel .stat-card {
                margin-bottom: 0;
            }
        }

        /* RESPONSIVE LAYOUT: quiz + sidebar */
        .quiz-layout {
            display: grid !important;
            grid-template-columns: minmax(0, 2fr) minmax(280px, 1fr);
            gap: 24px;
            align-items: start;
            margin-left: 0;
            margin-right: 0;
        }

        .quiz-layout>.col-12 {
            width: auto;
            max-width: none;
            padding-left: 0;
            padding-right: 0;
        }

        .quiz-sidebar {
            display: flex;
            flex-direction: column;
            gap: 18px;
            min-width: 0;
        }

        @media (max-width: 991.98px) {
            .quiz-layout {
                grid-template-columns: minmax(0, 1fr);
                gap: 18px;
            }

            /* Urutan mobile: countdown terlebih dahulu, statistics tepat di bawahnya */
            .quiz-sidebar {
                margin-top: 0;
            }
        }

        @media (max-width: 576px) {
            .container-main {
                padding: 20px 13px;
            }

            .quiz-card {
                padding: 27px 19px;
            }

            .question-word {
                margin-top: 42px;
            }

            .side-panel {
                padding: 19px;
            }

            .timer-value {
                font-size: 32px;
            }
        }
    </style>

</head>

<body>

    <!-- HEADER -->

    <header class="header">

        <div class="d-flex align-items-center gap-3">

            <div class="brand-icon">
                🍅
            </div>

            <div>

                <div class="d-flex align-items-center gap-2 flex-wrap">

                    <span class="brand-title">
                        みんなの農業日本語
                    </span>

                    <span class="brand-badge">
                        TOMATO
                    </span>

                </div>

                <div class="brand-subtitle">
                    • NIHONGO FARMING QUIZ
                </div>

            </div>

        </div>

    </header>

    <main class="container-main">

        <div class="row g-4 align-items-start quiz-layout">

            <div class="col-12 col-lg-10">

                <!-- QUIZ SECTION -->

                <section class="quiz-card" id="quiz-section">

                    <div class="d-flex justify-content-between align-items-center">

                        <div class="d-flex gap-2 flex-wrap">

                            <span class="badge-chapter" id="chapter">
                                Pertanian
                            </span>

                            <span class="badge-category">
                                農業
                            </span>

                        </div>

                        <span class="question-index" id="question-index">
                            1/79
                        </span>

                    </div>

                    <!-- KOTOBA -->

                    <h1 class="question-word" id="word">
                        農業
                    </h1>

                    <div class="question-reading" id="reading">
                        のうぎょう
                    </div>

                    <div class="divider"></div>

                    <p class="question-description">
                        Apa artinya dalam Bahasa Indonesia?
                    </p>

                    <!-- PILIHAN JAWABAN -->

                    <div id="options"></div>

                    <!-- FEEDBACK -->

                    <div class="feedback" id="feedback"></div>
                    <div class="countdown-track">
                        <div class="countdown-bar" id="countdown-bar"></div>
                    </div>
                    <!-- PROGRESS BAR -->

                    <div class="d-flex justify-content-between mb-2">

                        <small class="text-secondary">Progress latihan</small>

                        <small class="text-secondary" id="progress-text">
                            0%
                        </small>

                    </div>

                    <div class="progress mb-4">

                        <div
                            class="progress-bar"
                            id="progress"
                            style="width: 0%">
                        </div>

                    </div>


                </section>

            </div>

            <aside class="col-12 col-lg-6 quiz-sidebar">

                <div class="side-panel statistics-panel">
                    <div class="side-panel-heading">
                        <span class="side-icon">▦</span>
                        <span>STATISTICS</span>
                    </div>

                    <div class="stat-card">
                        <div class="stat-label">SOAL DIKERJAKAN</div>
                        <div class="stat-number" id="total-question">1</div>
                    </div>

                    <div class="row g-3">
                        <div class="col-6">
                            <div class="stat-card">
                                <div class="stat-label">BENAR</div>
                                <div class="stat-number text-success" id="correct-count">0</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card">
                                <div class="stat-label">SALAH</div>
                                <div class="stat-number text-danger" id="wrong-count">0</div>
                            </div>
                        </div>
                    </div>
                </div>

            </aside>

        </div>

        <!-- RESULT SECTION -->

        <section class="result-card d-none" id="result-section">

            <div class="result-title">
                お疲れ様！
            </div>

            <h3 class="mt-3">
                Latihan Selesai!
            </h3>

            <p class="mt-3" id="final-score"></p>

            <p class="text-secondary" id="final-message"></p>

            <button class="restart-btn mt-3" id="restart">
                Ulangi Latihan ↻
            </button>

        </section>

    </main>

    <script>
        // =====================================
        // 1. DATABASE DARI PHP
        // =====================================

        const vocabulary = <?php echo $vocabularyJson; ?>;

        // =====================================
        // 2. VARIABEL QUIZ
        // =====================================

        let questions = [];

        let currentQuestion = 0;

        let correct = 0;

        let wrong = 0;

        let elapsedTime = 0;

        let timerInterval;

        let countdownInterval;

        let nextTimeout;

        let answered = false;

        function shuffle(array) {

            let result = [...array];

            for (let i = result.length - 1; i > 0; i--) {

                let j = Math.floor(Math.random() * (i + 1));

                [result[i], result[j]] = [result[j], result[i]];

            }

            return result;

        }

        function generateQuestions() {

            questions = shuffle(vocabulary).map(item => {

                let wrongAnswers = shuffle(

                    vocabulary.filter(v => v[2] !== item[2])

                ).slice(0, 3);

                let options = shuffle([

                    item,

                    ...wrongAnswers

                ]);

                return {

                    word: item[0],

                    reading: item[1],

                    meaning: item[2],

                    category: item[3],

                    options: options

                };

            });

        }

        function updateStatistics() {

            $("#total-question").text(
                currentQuestion + 1
            );

            $("#correct-count").text(correct);

            $("#wrong-count").text(wrong);

            $("#question-index").text(

                `${currentQuestion + 1}/${questions.length}`

            );

            let percentage =

                (currentQuestion / questions.length) * 100;

            $("#progress").css(

                "width",

                percentage + "%"

            );

            $("#progress-text").text(

                Math.round(percentage) + "%"

            );

        }

        function displayQuestion() {

            answered = false;

            let q = questions[currentQuestion];

            updateStatistics();

            $("#word").text(q.word);

            $("#reading").text(q.reading);

            $("#chapter").text(q.category);

            $("#feedback")

                .text("")

                .removeClass("correct-text wrong-text");

            $("#countdown").addClass("d-none");

            $("#countdown-bar").css("width", "0%");

            $("#options").empty();

            // Tampilkan empat pilihan jawaban

            q.options.forEach((option, index) => {

                let button = $(`

                    <button
                        type="button"
                        class="answer-btn">

                        ${option[2]}

                    </button>

                `);

                button.on("click", function() {

                    checkAnswer(option, button);

                });

                $("#options").append(button);

            });

        }

        // =====================================
        // 7. CHECK ANSWER
        // =====================================

        function checkAnswer(selected, button) {

            if (answered) return;

            answered = true;

            let q = questions[currentQuestion];

            // Nonaktifkan semua pilihan

            $(".answer-btn").prop("disabled", true);

            if (selected[2] === q.meaning) {

                // JAWABAN BENAR

                correct++;

                button.addClass("correct");

                $("#feedback")

                    .text("✓ Benar! 正解です！")

                    .addClass("correct-text");

            } else {

                // JAWABAN SALAH

                wrong++;

                button.addClass("wrong");

                // Tampilkan jawaban yang benar

                $(".answer-btn").each(function(index) {

                    let option = q.options[index];

                    if (option[2] === q.meaning) {

                        $(this).addClass("correct");

                    }

                });

                $("#feedback")

                    .text("✕ Kurang tepat! Jawaban: " + q.meaning)

                    .addClass("wrong-text");

            }

            $("#correct-count").text(correct);

            $("#wrong-count").text(wrong);

            // Mulai countdown

            startCountdown();

        }

        // =====================================
        // 8. COUNTDOWN 5 DETIK
        // =====================================

        function startCountdown() {

            let remaining = 3;

            $("#countdown").removeClass("d-none");

            $("#countdown-text").text(

                `Lanjut otomatis dalam ${remaining} detik...`

            );

            countdownInterval = setInterval(function() {

                remaining--;

                $("#countdown-text").text(
                    remaining > 0
                    ?
                    `Lanjut otomatis dalam ${remaining} detik...`
                    :
                    "Memuat soal berikutnya..."
                );

                let percentage = (3 - remaining) * 33.33;
                $("#countdown-bar").css(
                    "width",
                    percentage + "%"
                );

                if (remaining <= 0) {
                    clearInterval(countdownInterval);
                }
            }, 1000);
            nextTimeout = setTimeout(function() {
                nextQuestion();
            }, 5000);
        }

        function nextQuestion() {
            clearInterval(countdownInterval);
            clearTimeout(nextTimeout);
            currentQuestion++;
            if (currentQuestion < questions.length) {
                displayQuestion();
            } else {
                finishQuiz();
            }
        }

        function startTimer() {
            clearInterval(timerInterval);
            elapsedTime = 0;
            timerInterval = setInterval(function() {
                elapsedTime++;
                let minutes = Math.floor(elapsedTime / 60);
                let seconds = elapsedTime % 60;
                $("#timer").text(
                    `${minutes}:${String(seconds).padStart(2, "0")}`
                );
            }, 1000);
        }

        function finishQuiz() {
            clearInterval(timerInterval);
            $("#quiz-section").addClass("d-none");
            $("#result-section").removeClass("d-none");
            $("#progress").css("width", "100%");
            $("#progress-text").text("100%");
            $("#total-question").text(questions.length);
            let percentage = Math.round(
                (correct / questions.length) * 100
            );
            $("#final-score").text(
                `Skor kamu: ${correct}/${questions.length} (${percentage}%)`
            );

            let message = "";
            if (percentage === 100) {
                message = "Sempurna! Semua jawaban benar!";
            } else if (percentage >= 80) {
                message = "Bagus! Penguasaan kotoba kamu sudah sangat baik.";
            } else if (percentage >= 50) {
                message = "Lumayan! Terus tingkatkan kemampuan kosakatamu.";
            } else {
                message = "Tetap semangat! Coba pelajari kembali kosakatanya.";
            }
            $("#final-message").text(message);
        }

        function restartQuiz() {

            clearInterval(timerInterval);

            clearInterval(countdownInterval);

            clearTimeout(nextTimeout);

            currentQuestion = 0;

            correct = 0;

            wrong = 0;

            $("#quiz-section").removeClass("d-none");

            $("#result-section").addClass("d-none");

            $("#correct-count").text(0);

            $("#wrong-count").text(0);

            $("#timer").text("0:00");

            generateQuestions();

            displayQuestion();

            startTimer();

        }

        $(document).ready(function() {

            console.log("Jumlah kosakata:", vocabulary.length);

            if (!Array.isArray(vocabulary) || vocabulary.length < 4) {

                $("#quiz-section").html(

                    "<p class='text-danger text-center'>Database kosakata tidak mencukupi.</p>"

                );

                return;

            }

            // Mulai latihan

            restartQuiz();

            // Tombol ulangi

            $("#restart").on("click", function() {

                restartQuiz();

            });

        });
    </script>

</body>

</html>