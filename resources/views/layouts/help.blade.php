<!-- resources/views/layouts/help.blade.php -->
<div id="helpModal" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); padding:20px; background:white; z-index:1000; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
    <h2>Ayuda en Línea</h2>
    <p id="helpContent">Aquí va el contenido de ayuda. Puedes personalizarlo.</p>
    <button onclick="closeHelp()">Cerrar</button>
</div>
<div id="overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0, 0, 0, 0.5); z-index:999;"></div>
