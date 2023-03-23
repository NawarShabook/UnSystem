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

        // btnUpdate=document.getElementById('update').setAttribute("hidden","");
        // document.getElementById('delete').setAttribute("hidden","");
        
}


function checkImageUpload()
{
    const fileInput = document.querySelector('#image-input');
    if (fileInput.files.length > 0)
    {
        const image=document.getElementById('stdImage');
        image.classList.add("border" ,"border-success");
        const checkedBadge=document.getElementById('checked-badge');
        checkedBadge.classList.remove("d-none")
    } 
}
    

function filterSrch(col,idd)
{
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById(idd);
        filter = input.value.toUpperCase();
        table = document.getElementById("std");
        console.log(table);
        tr = table.getElementsByTagName("tr");
        
        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[col];
            if (td) {
            txtValue = td.textContent || td.innerText;
            if(idd==="room")
            {
                if(txtValue.trim()==filter || filter==''){
                    tr[i].style.display = "";
                } else {
                tr[i].style.display = "none";
                }
               continue;
            }
                
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

function selectEmail(clickedElement)
{
    //get value of email
    var email = clickedElement.getAttribute('value');
    //add hidden input has email address

    //get form
    const form = document.getElementById('createForm');

    var emailInput = document.createElement("input");
    emailInput.type = "hidden";
    emailInput.name = "email";
    emailInput.value = email;

    form.appendChild(emailInput);
    console.log(emailInput);
}