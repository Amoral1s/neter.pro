jQuery(document).ready(function ($) {

const calc = document.querySelector('.calculation');

if (calc) {
  const ranges = document.querySelectorAll('input[type="range"]');
  if (ranges.length > 0) {
    ranges.forEach(elem => {
      let minVal = +elem.dataset.min;
      let maxVal = +elem.dataset.max;
      let stepVal = +elem.dataset.step;
      let defaultVal = +elem.dataset.default;
  
      const elemTextValue = elem.parentElement.querySelector('.view-val');
  
      var rangeInput = $(elem).ionRangeSlider({
        skin: "round",
        type: "single",
        min: minVal,
        max: maxVal,
        from: defaultVal,
        step: stepVal,
        onChange: function (data) {
          elemTextValue.value = data.from;  // Изменяем текстовое поле при изменении значения диапазона
        }
      });
  
      const rangeInstance = rangeInput.data("ionRangeSlider");
  
      elemTextValue.addEventListener('change', () => {
        // Получаем минимальное и максимальное значения из атрибутов data-min и data-max
        const min = minVal;
        const max = maxVal;
  
        // Фильтруем ввод, чтобы разрешить только цифры
        let value = elemTextValue.value.replace(/[^0-9]/g, '');
        // Преобразуем значение в число
        let numericValue = parseInt(value, 10);
  
        // Проверяем, если значение меньше минимального
        if (numericValue < min) {
          numericValue = min;
        }
  
        // Проверяем, если значение больше максимального
        if (numericValue > max) {
          numericValue = max;
        }
  
        // Устанавливаем отфильтрованное и скорректированное значение обратно в элемент
        elemTextValue.value = numericValue;
  
        // Обновляем значение диапазона
        rangeInstance.update({
          from: numericValue
        });
      });
    });
  }
  const topWrappers = calc.querySelectorAll('.top');

  topWrappers.forEach(elem => {
    const input = elem.querySelector('input');
    if (input) {
      input.addEventListener('change', () => {
        if (input.checked) {
          input.closest('.item').classList.add('disabled-calc');
        } else {
          input.closest('.item').classList.remove('disabled-calc');
        }
      })
    }
  });

  function calculate() {
    const typeInputs = calc.querySelectorAll('input[name="type"]');
    const typeHelp = calc.querySelectorAll('input[name="type-help"]');
    const corpInputs = calc.querySelectorAll('input[name="corp"]');
    const corpHelp = calc.querySelectorAll('input[name="corp-help"]');
    const rangeV = calc.querySelector('#range-V');
    const rangeAH = calc.querySelector('#range-AH');
    const rangeA = calc.querySelector('#range-A');

    let typeVal;
    let corpVal;
    let Vval = `${rangeV.value} В`;
    let AHval = `${rangeAH.value} Ач`;
    let Aval = `${rangeA.value} А`;

    if (typeHelp.checked) {
      typeVal = 'Помочь с выбором';
    } else {
      typeInputs.forEach(e => {
        if (e.checked) {
          typeVal = e.value;
        }
      })
    }

    if (corpHelp.checked) {
      corpVal = 'Помочь с выбором';
    } else {
      corpInputs.forEach(e => {
        if (e.checked) {
          corpVal = e.value;
        }
      })
    }

    let dataText = `
      Тип химии: ${typeVal}
      Корпус: ${corpVal}
      Напряжение: ${Vval}
      Емкость: ${AHval}
      Ток: ${Aval}
    `;

    const dataInput = document.querySelector('input[name="DataCalc"]');
    if (dataInput) {
      dataInput.value = dataText;
      console.log(dataInput.value)
    }
  }
  
  calc.addEventListener('click', () => {
    calculate();
  })


}




}); //end
