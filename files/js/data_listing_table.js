/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var initTable = function() {
        function save_dt_view(oSettings, oData) {
            localStorage.setItem('DataTables_' + window.location.pathname, JSON.stringify(oData));
        }
        function load_dt_view(oSettings) {
            return JSON.parse(localStorage.getItem('DataTables_' + window.location.pathname));
        }
        function reset_dt_view() {
            localStorage.removeItem('DataTables_' + window.location.pathname);
        }

        function fnFormatDetails(oTable, nTr)
        {
            var aData = oTable.fnGetData(nTr);
            var sOut = '<table>';
            sOut += '<tr><td>Platform(s):</td><td>' + aData[2] + '</td></tr>';
            sOut += '<tr><td>Engine version:</td><td>' + aData[3] + '</td></tr>';
            sOut += '<tr><td>CSS grade:</td><td>' + aData[4] + '</td></tr>';
            sOut += '<tr><td>Others:</td><td>Could provide a link here</td></tr>';
            sOut += '</table>';

            return sOut;
        }

        /*
         * Insert a 'details' column to the table
         */


        /*
         * Initialse DataTables, with no sorting on the 'details' column
         */
        var oTable = $('#user_list').dataTable({
            "bStateSave": true,
            "fnStateSave": function(oSettings, oData) {
                save_dt_view(oSettings, oData);
            },
            
            "fnStateLoad": function(oSettings) {
                return load_dt_view(oSettings);
            },
            "aoColumnDefs": [
                {"bSortable": false, "aTargets": [1]}
            ],
            "aaSorting": [[0, 'asc']],
            "aLengthMenu": [
                [10, 15, 20, -1],
                [10, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "iDisplayLength": 10,
        });

        
        /* Add event listener for opening and closing details
         * Note that the indicator for showing which row is open is not controlled by DataTables,
         * rather it is done here
         */

    }
    $(document).ready(function(){
        initTable();
  
    });
    

