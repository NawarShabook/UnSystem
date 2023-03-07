function test_college(select_id,cls)
    {
        var selectElement = document.getElementById('section');
        var options = selectElement.options;
        for (var i = 1; i < options.length; i++) {
            options[i].setAttribute("hidden" ,"");

        }
        
        var selectedId=document.getElementById(select_id).selectedIndex;
        selected=document.getElementsByClassName(cls)[selectedId].value;
        sect=document.getElementsByClassName(selected);
        for (let index = 0; index < sect.length; index++) {
            sect[index].removeAttribute("hidden");
        }
    }



function updateStudent()
    {
        inputs=document.querySelectorAll('input');
        inputs.forEach(input => {
            input.removeAttribute("disabled");
            input.classList.add("border-dark")
        });
        selects=document.querySelectorAll('select');
        selects.forEach(select => {
            select.removeAttribute("disabled");
        });

        dsNone=document.getElementsByClassName('hd');
       
        for (let index = 0; index < dsNone.length; index++) {
            dsNone[index].removeAttribute("hidden","");

        }

        btnUpdate=document.getElementById('update').setAttribute("hidden","");
        document.getElementById('delete').setAttribute("hidden","");
        
    }