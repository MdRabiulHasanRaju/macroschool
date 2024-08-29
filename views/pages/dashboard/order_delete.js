
let alertMessage = document.getElementById("bkash_payment_notice");

let course_delete = document.querySelectorAll(".course_delete");


let deleteOrderHandler = (order) => {
    order.forEach((element) => {
        element.addEventListener("click", () => {
            let course_id = element.dataset.orderid;
            let order = element.parentNode;
    
            let ajax = new XMLHttpRequest();
        
            ajax.open('POST','/macroschool/controllers/deleteOrderController.php',true);
        
            ajax.onprogress = function(){
                
            }
        
            ajax.onload = function(){
                if(ajax.status==200){
                    let obj = JSON.parse(this.responseText);
                    alertMessage.innerHTML = obj.success;
                    order.remove()
                }
                if(ajax.status==403){
                    let obj = JSON.parse(this.responseText);
                    alertMessage.innerHTML = obj.err;
                }
            }
        
            ajax.setRequestHeader('Content-type','application/x-www-form-urlencoded');
        
            let data = 'course_id='+course_id;
        
            ajax.send(data);
        })
    })


 
};
  
//if(course_delete) course_delete.addEventListener("click", deleteOrderHandler);
deleteOrderHandler(course_delete)
