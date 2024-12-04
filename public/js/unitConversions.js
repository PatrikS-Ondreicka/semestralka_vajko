speedButton = document.getElementById("speedChangeButton");
tempButton = document.getElementById("tempChangeButton");
precipButton = document.getElementById("precipChangeButton");

function conversion(button, unit1, unit2, unit1Conversion, unit2Conversion, vb_class, val_class, unit_class) {
    let conversionFormula = unit1Conversion;
    let unitText = unit1;

    if (button.innerHTML == unit1) {
        conversionFormula = unit2Conversion;
        unitText = unit2;
        button.innerHTML = unit2;
    } else {
        button.innerHTML = unit1;
    }

    const speedValBlocks = document.getElementsByClassName(vb_class);
    for (let i = 0; i < speedValBlocks.length; i++) {
        let tempValBlock = speedValBlocks[i];
        let value = tempValBlock.getElementsByClassName(val_class)[0];
        let unit = tempValBlock.getElementsByClassName(unit_class)[0];
        value.innerText = conversionFormula(value.innerText).toFixed(2);
        unit.innerText = unitText
    }
}
speedButton.onclick = () => {conversion(speedButton, 'mph', 'km/h',
    (value) => {return value / 1.609;}, (value) => {return value * 1.609;},
    'speed_val_block', 'ws_val', 'ws_unit')}

tempButton.onclick = () => {conversion(tempButton, '°F', '°C',
    (value) => {return ((value) * 9/5) + 32;}, (value) => {return (value - 32) * (5/9);},
    'temp_val_block', 'temp_val', 'temp_unit')}

precipButton.onclick = () => {conversion(precipButton, 'in', 'mm',
    (value) => {return value / 25.4;}, (value) => {return value * 25.4;},
    'precip_val_block', 'precip_val', 'precip_unit')}

