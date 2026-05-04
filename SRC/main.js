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
        const mockDB = {
        };
        
        await new Promise(resolve => setTimeout(resolve, 500));
        const data = mockDB[planetId] || [];

        tbody.innerHTML = '';

        if (data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="3">Aucune donnée disponible pour le moment.</td></tr>';
            return;
        }

        data.forEach(row => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${row.nom}</td>
                <td><div class="img-placeholder">${row.image}</div></td>
                <td>${row.date}</td>
            `;
            tbody.appendChild(tr);
        });

        tbody.setAttribute('data-loaded', 'true');

    } catch (error) {
        console.error("Erreur de connexion à la BDD :", error);
        tbody.innerHTML = '<tr><td colspan="3">Erreur lors de la récupération des données.</td></tr>';
    }
}