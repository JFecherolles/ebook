console.log('Script : init');


(function() {
    'use strict';
  
    // TableFilter sert à filtrer les tableaux
    const TableFilter = (function() {
      const Arr = Array.prototype;
      let input;
  
      function onInputEvent(e) {
        input = e.target;
        const table1 = document.getElementsByClassName(input.getAttribute('data-table'));
        Arr.forEach.call(table1, function(table) {
          Arr.forEach.call(table.tBodies, function(tbody) {
            Arr.forEach.call(tbody.rows, filter);
          });
        });
      }
  
      function filter(row) {
        const text = row.textContent.toLowerCase();
        const val = input.value.toLowerCase();
        row.style.display = text.indexOf(val) === -1 ? 'none' : 'table-row';
      }
  
      return {
        // Fonction qui initialise le filtre
        init: function() {
          const inputs = document.getElementsByClassName('table-filter');
          Arr.forEach.call(inputs, function(input) {
            input.oninput = onInputEvent;
          });
        }
      };
  
    })();
  
   TableFilter.init();
  })();