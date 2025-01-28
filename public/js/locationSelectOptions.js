let manualRadio = document.querySelectorAll('input[name="selection_mode"][value="manual"]')[0];
let mapRadio = document.querySelectorAll('input[name="selection_mode"][value="map"]')[0];

let selectionContentDiv = document.getElementById('location_selection_content');

function mapInit() {
    const map = L.map('map');
    map.dragging.disable();
    map.scrollWheelZoom.disable();
    map.doubleClickZoom.disable();
    map.touchZoom.disable();
    map.keyboard.disable();
    map.zoomControl.remove();
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
}

function setContentVisible (content, content_class_name)
{
    let contentArray = document.querySelectorAll("." + content_class_name);
    Array.from(contentArray).forEach((item) => {item.style.display = "none";});
    content.style.display = "flex";
}

manualRadio.onchange = () => {
    let content = document.getElementById('man_selection_content');
    setContentVisible(content, "selection_content");
}

mapRadio.onchange =  () => {
    let content = document.getElementById('map_selection_content');
    setContentVisible(content, "selection_content");
    mapInit();
}