function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
}

function showLayer(layerId) {
    document.querySelectorAll('.layer').forEach(layer => {
        layer.classList.remove('active');
    });

    document.getElementById('layer-' + layerId).classList.add('active');

    document.body.className = '';
    document.body.classList.add('theme-' + layerId);

    if (layerId === 'Quiz') {
        initQuiz();
    } else if (layerId !== 'home') {
        fetchData(layerId);
    }

    toggleSidebar();
}

const planetData = {};
const planetCols = {};

function wireSearch(planetId) {
    const layer = document.getElementById('layer-' + planetId);
    if (!layer) return;
    const input = layer.querySelector('.search-bar input');
    if (!input) return;

    const fresh = input.cloneNode(true);
    input.parentNode.replaceChild(fresh, input);

    fresh.addEventListener('input', () => {
        filterTable(planetId, fresh.value.trim());
    });
}

function filterTable(planetId, query) {
    const tbody = document.getElementById('tbody-' + planetId);
    if (!tbody) return;

    const rows   = Array.from(tbody.querySelectorAll('tr'));
    const cols   = planetCols[planetId] || [];
    const data   = planetData[planetId] || [];

    const titleIndices = cols.reduce((acc, col, i) => {
        const c = col.toLowerCase();
        if (c === 'name' || c.includes('title')) {
            acc.push(i);
        }
        return acc;
    }, []);

    const searchIndices = titleIndices.length > 0
        ? titleIndices
        : cols.reduce((acc, col, i) => {
            const c = col.toLowerCase();
            if (!c.includes('url') && !c.includes('desc') && !c.includes('expl') && c !== 'image' && c !== 'img') {
                acc.push(i);
            }
            return acc;
        }, []);

    const tokens = query.toLowerCase().split(/\s+/).filter(Boolean);

    const tableContainer = tbody.closest('.table-container');
    const showMoreBtn    = tableContainer ? tableContainer.querySelector('.show-more-btn') : null;

    if (tokens.length === 0) {
        rows.forEach((tr, index) => {
            tr.style.display = '';
            if (data.length > 10) {
                if (index >= 10) tr.classList.add('hidden-row');
                else             tr.classList.remove('hidden-row');
            }
        });
        if (showMoreBtn) showMoreBtn.style.display = '';
        return;
    }

    if (showMoreBtn) showMoreBtn.style.display = 'none';

    rows.forEach((tr, index) => {
        const rowObj = data[index];
        if (!rowObj) { tr.style.display = 'none'; return; }

        const haystack = searchIndices
            .map(i => String(rowObj[cols[i]] || '').toLowerCase())
            .join(' ');

        const matches = tokens.every(token => haystack.includes(token));

        tr.classList.remove('hidden-row');
        tr.style.display = matches ? '' : 'none';
    });
}

async function fetchData(planetId) {
    const tbody = document.getElementById('tbody-' + planetId);
    if (!tbody) return;

    if (tbody.getAttribute('data-loaded') === 'true') {
        wireSearch(planetId);
        return;
    }

    tbody.innerHTML = '<tr><td colspan="3">Loading data from the database...</td></tr>';

    try {
        const response = await fetch(`api.php?planet=${planetId}`);

        if (!response.ok) {
            const errorData = await response.json().catch(() => ({}));
            throw new Error(errorData.error || `HTTP Error: ${response.status}`);
        }

        const data = await response.json();

        tbody.innerHTML = '';

        if (data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="3">No data available at the moment.</td></tr>';
            return;
        }

        const columns = Object.keys(data[0]).filter(col => col.toLowerCase() !== 'copyright');

        planetData[planetId] = data;
        planetCols[planetId] = columns;

        const thead = tbody.parentElement.querySelector('thead');
        thead.innerHTML = '<tr>' + columns.map(col => {
            const colLower = col.toLowerCase();
            const isDesc = colLower.includes('desc') || colLower.includes('expl');
            const isUrl  = colLower.includes('url')  || colLower === 'image' || colLower === 'img';

            let className = '';
            if (isDesc)     className = ' class="col-desc"';
            else if (isUrl) className = ' class="col-url"';
            return `<th${className}>${col.toUpperCase()}</th>`;
        }).join('') + '</tr>';

        data.forEach((row, index) => {
            const tr = document.createElement('tr');

            if (index >= 10) tr.classList.add('hidden-row');

            let rowHtml = '';
            columns.forEach(col => {
                const colLower = col.toLowerCase();
                const colLabel = col.toUpperCase();
                if (colLower.includes('url') || colLower === 'image' || colLower === 'img') {
                    const url = row[col];
                    if (url && url.trim() !== '') {
                        rowHtml += `<td class="col-url" data-label="${colLabel}">
                            <a href="${url}" target="_blank" rel="noopener noreferrer">
                                ${url}
                            </a>
                        </td>`;
                    } else {
                        rowHtml += `<td class="col-url" data-label="${colLabel}">N/A</td>`;
                    }
                } else if (colLower.includes('desc') || colLower.includes('expl')) {
                    const text = row[col] || '';
                    let fontSizeStyle = '';
                    if (text.length > 200)      fontSizeStyle = ' font-size: 0.75rem;';
                    else if (text.length > 100) fontSizeStyle = ' font-size: 0.85rem;';
                    rowHtml += `<td class="col-desc" style="${fontSizeStyle}" data-label="${colLabel}">${text}</td>`;
                } else {
                    rowHtml += `<td data-label="${colLabel}">${row[col]}</td>`;
                }
            });

            tr.innerHTML = rowHtml;
            tbody.appendChild(tr);
        });

        const tableContainer = tbody.closest('.table-container');
        if (tableContainer) {
            tableContainer.style.overflowX = 'auto';
            tableContainer.style.maxWidth = '100%';
            tableContainer.style.WebkitOverflowScrolling = 'touch';
        }
        const existingBtn = tableContainer.querySelector('.show-more-btn');
        if (existingBtn) existingBtn.remove();

        if (data.length > 10) {
            const btn = document.createElement('button');
            btn.innerHTML = 'Show more ⬇';
            btn.className = 'show-more-btn';
            btn.onclick = () => {
                tbody.querySelectorAll('.hidden-row').forEach(row => row.classList.remove('hidden-row'));
                btn.remove();
            };
            tableContainer.appendChild(btn);
        }

        tbody.setAttribute('data-loaded', 'true');

        wireSearch(planetId);

    } catch (error) {
        console.error("Database connection error:", error);
        tbody.innerHTML = `<tr><td colspan="3" style="color: #ff4444;">Technical error: ${error.message}</td></tr>`;
    }
}

let quizQuestions = [];
let currentQuizIndex = 0;
let quizScore = 0;

async function initQuiz() {
    currentQuizIndex = 0;
    quizScore = 0;
    document.getElementById('quiz-restart-btn').style.display = 'none';
    document.getElementById('quiz-score').textContent = '';

    if (quizQuestions.length === 0) {
        document.getElementById('quiz-question').textContent = "Loading today's Quiz...";
        document.getElementById('quiz-options').innerHTML = '';
        
        try {
            const response = await fetch(`api.php?planet=quiz`);
            if (!response.ok) {
                let errMsg = "Network error";
                try {
                    const errData = await response.json();
                    if (errData.error) errMsg = errData.error;
                } catch (e) {}
                throw new Error(errMsg);
            }
            quizQuestions = await response.json();

            if (quizQuestions.length === 0) {
                document.getElementById('quiz-question').textContent = "Not enough data in the database to generate a quiz.";
                return;
            }
        } catch (error) {
            console.error("Quiz Error:", error);
            document.getElementById('quiz-question').textContent = "Error: " + error.message;
            return;
        }
    }

    showQuizQuestion();
}

function showQuizQuestion() {
    const preview = document.getElementById('quiz-img-preview');

    if (currentQuizIndex >= quizQuestions.length) {
        document.getElementById('quiz-question').textContent = "Today's Quiz finished!";
        document.getElementById('quiz-options').innerHTML = "";
        document.getElementById('quiz-score').textContent = `Your score: ${quizScore} / ${quizQuestions.length}`;
        document.getElementById('quiz-restart-btn').style.display = 'inline-block';
        if (preview) preview.classList.remove('visible');
        return;
    }

    const qObj = quizQuestions[currentQuizIndex];
    document.getElementById('quiz-question').innerText = `Question ${currentQuizIndex + 1}/${quizQuestions.length}:\n\n${qObj.q}`;

    const optionsContainer = document.getElementById('quiz-options');
    optionsContainer.innerHTML = '';

    qObj.options.forEach(opt => {
        const btn = document.createElement('button');
        btn.className = 'quiz-btn';
        btn.textContent = opt;
        btn.onclick = () => checkAnswer(opt, qObj.a, btn);
        optionsContainer.appendChild(btn);
    });

    if (preview) {
        preview.classList.remove('visible');
        const oldImg = preview.querySelector('img');
        const oldVid = preview.querySelector('video');
        if (oldImg) { oldImg.src = ''; oldImg.style.display = 'none'; }
        if (oldVid) { oldVid.pause(); oldVid.src = ''; oldVid.style.display = 'none'; }

        if (qObj.img && qObj.img.trim() !== '') {
            const url = qObj.img.trim();
            const isVideo = /\.(mp4|webm|ogg|mov)(\?.*)?$/i.test(url);
            const caption = preview.querySelector('.quiz-img-caption');

            requestAnimationFrame(() => {
                if (isVideo) {
                    let vid = preview.querySelector('video');
                    if (!vid) {
                        vid = document.createElement('video');
                        vid.controls = true;
                        vid.preload = 'metadata';
                        vid.style.display = 'none';
                        preview.querySelector('.quiz-img-label').insertAdjacentElement('afterend', vid);
                    }
                    vid.src = url;
                    vid.style.display = 'block';
                    if (oldImg) oldImg.style.display = 'none';
                } else {
                    if (oldImg) {
                        oldImg.src = url;
                    oldImg.alt = 'Image associated with the question';
                        oldImg.style.display = 'block';
                    }
                    if (oldVid) oldVid.style.display = 'none';
                }
                caption.textContent = url;
                preview.classList.add('visible');
            });
        }
    }
}

function checkAnswer(selected, correct, btn) {
    const optionsContainer = document.getElementById('quiz-options');
    const buttons = optionsContainer.querySelectorAll('.quiz-btn');

    buttons.forEach(b => {
        b.disabled = true;
        b.style.cursor = 'default';
    });

    if (selected === correct) {
        btn.classList.add('correct');
        quizScore++;
    } else {
        btn.classList.add('wrong');
        buttons.forEach(b => {
            if (b.textContent === correct) b.classList.add('correct');
        });
    }

    setTimeout(() => {
        currentQuizIndex++;
        showQuizQuestion();
    }, 1800);
}

function openCredits() {
    document.getElementById('credits-panel').classList.add('open');
    document.getElementById('credits-overlay').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeCredits() {
    document.getElementById('credits-panel').classList.remove('open');
    document.getElementById('credits-overlay').classList.remove('open');
    document.body.style.overflow = '';
}

document.addEventListener('DOMContentLoaded', () => {
    const overlay = document.getElementById('credits-overlay');
    if (overlay) overlay.addEventListener('click', closeCredits);

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeCredits();
    });

    const isMobile = window.innerWidth <= 768 || /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    
    if (isMobile) {
        const iframes = document.querySelectorAll('iframe');
        iframes.forEach(iframe => {
            const fallback = document.createElement('div');
            fallback.textContent = "functionality not available on mobile devices";
            fallback.style.display = "flex";
            fallback.style.alignItems = "center";
            fallback.style.justifyContent = "center";
            fallback.style.minHeight = "200px";
            fallback.style.backgroundColor = "#1e293b";
            fallback.style.color = "#f87171";
            fallback.style.border = "1px solid #334155";
            fallback.style.borderRadius = "8px";
            fallback.style.padding = "20px";
            fallback.style.textAlign = "center";

            iframe.parentNode.replaceChild(fallback, iframe);
        });
    }
});