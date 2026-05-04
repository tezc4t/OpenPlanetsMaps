function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
}

function showLayer(layerId) {
    document.querySelectorAll('.layer').forEach(layer => {
        layer.classList.remove('active');
    });
    
    document.getElementById('layer-' + layerId).classList.add('active');
    
    toggleSidebar();
}

async function fetchData() {
}