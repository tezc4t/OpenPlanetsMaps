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
    
    if (layerId !== 'home') {
        fetchData(layerId);
    }

    toggleSidebar();
}

async function fetchData(planetId) {
    const tbody = document.getElementById('tbody-' + planetId);
    if (!tbody) return;

    if (tbody.getAttribute('data-loaded') === 'true') return;

    tbody.innerHTML = '<tr><td colspan="3">Chargement des données depuis la BDD...</td></tr>';

    try {
        const response = await fetch(`api.php?planet=${planetId}`);
        
        if (!response.ok) {
            const errorData = await response.json().catch(() => ({}));
            throw new Error(errorData.error || `Erreur HTTP: ${response.status}`);
        }
        
        const data = await response.json();

        tbody.innerHTML = '';

        if (data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="3">Aucune donnée disponible pour le moment.</td></tr>';
            return;
        }

        const columns = Object.keys(data[0]).filter(col => col.toLowerCase() !== 'copyright');
        
        const thead = tbody.parentElement.querySelector('thead');
        thead.innerHTML = '<tr>' + columns.map(col => {
            const colLower = col.toLowerCase();
            const isDesc = colLower.includes('desc') || colLower.includes('expl');
            const isUrl = colLower.includes('url') || colLower === 'image' || colLower === 'img';
            
            let className = '';
            if (isDesc) className = ' class="col-desc"';
            else if (isUrl) className = ' class="col-url"';
            return `<th${className}>${col.toUpperCase()}</th>`;
        }).join('') + '</tr>';

        data.forEach((row, index) => {
            const tr = document.createElement('tr');
            
            if (index >= 10) {
                tr.classList.add('hidden-row');
            }
            
            let rowHtml = '';
            columns.forEach(col => {
                const colLower = col.toLowerCase();
                if (colLower.includes('url') || colLower === 'image' || colLower === 'img') {
                    const url = row[col];
                    if (url && url.trim() !== '') {
                        rowHtml += `<td class="col-url">
                            <a href="${url}" target="_blank" rel="noopener noreferrer" style="color: inherit; text-decoration: underline; font-weight: 500;">
                                ${url}
                            </a>
                        </td>`;
                    } else {
                        rowHtml += `<td class="col-url">N/A</td>`;
                    }
                } else if (colLower.includes('desc') || colLower.includes('expl')) {
                    const text = row[col] || '';
                    let fontSizeStyle = '';
                    if (text.length > 200) fontSizeStyle = ' font-size: 0.75rem;';
                    else if (text.length > 100) fontSizeStyle = ' font-size: 0.85rem;';
                    rowHtml += `<td class="col-desc" style="${fontSizeStyle}">${text}</td>`;
                } else {
                    rowHtml += `<td>${row[col]}</td>`;
                }
            });
            tr.innerHTML = rowHtml;
            tbody.appendChild(tr);
        });

        const tableContainer = tbody.closest('.table-container');
        
        const existingBtn = tableContainer.querySelector('.show-more-btn');
        if (existingBtn) existingBtn.remove();

        if (data.length > 10) {
            const btn = document.createElement('button');
            btn.innerHTML = 'Voir la suite ⬇';
            btn.className = 'show-more-btn';
            btn.onclick = () => {
                tbody.querySelectorAll('.hidden-row').forEach(row => row.classList.remove('hidden-row'));
                btn.remove();
            };
            tableContainer.appendChild(btn);
        }

        tbody.setAttribute('data-loaded', 'true');

    } catch (error) {
        console.error("Erreur de connexion à la BDD :", error);
        tbody.innerHTML = `<tr><td colspan="3" style="color: #ff4444;">Erreur technique : ${error.message}</td></tr>`;
    }
}