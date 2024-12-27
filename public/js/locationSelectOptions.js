let manualRadio = document.querySelectorAll('input[name="selection_mode"][value="manual"]')[0];
let automaticRadio = document.querySelectorAll('input[name="selection_mode"][value="automatic"]')[0];
let mapRadio = document.querySelectorAll('input[name="selection_mode"][value="map"]')[0];

let selectionContentDiv = document.getElementById('location_selection_content');

function setContentVisible (content, content_class_name)
{
    let contentArray = document.getElementsByClassName(content_class_name);
    contentArray.forEach((item) => {item.style.visibility = "hidden";});
    content.style.visibility = "visible";
}

manualRadio.onchange = () => {
    let content = document.getElementById('man_selection_content');
    setContentVisible(content, "selection_content");
}

automaticRadio.onchange =  () => {
    let content = document.getElementById('auto_selection_content');
    setContentVisible(content, "selection_content");
}

mapRadio.onchange =  () => {
    let content = document.getElementById('map_selection_content');
    setContentVisible(content, "selection_content");
}