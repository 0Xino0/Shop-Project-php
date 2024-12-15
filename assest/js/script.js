const ul = document.querySelector(".tag-box ul"),
input = document.querySelector(".tag-box ul input"),
tagNumb = document.querySelector(".details span");

let maxTags = 10,
tags = [];

countTags();
createTag();

function countTags(){
    input.focus();
    tagNumb.innerText = maxTags - tags.length;
}

function createTag(){
    ul.querySelectorAll("li").forEach(li => li.remove());
    tags.slice().reverse().forEach(tag =>{
        let liTag = `<li id"tag" value"${tag}"> ${tag} <i class="uit uit-multiply" onclick="remove(this, '${tag}')"></i></li>`;
        ul.insertAdjacentHTML("afterbegin", liTag);
    });
    countTags();
}

function remove(element, tag){
    let index  = tags.indexOf(tag);
    tags = [...tags.slice(0, index), ...tags.slice(index + 1)];
    element.parentElement.remove();
    countTags();
}

function addTag(e){
    if(e.key == "Enter"){
        let tag = e.target.value.replace(/\s+/g, ' ');
        if(tag.length > 1 && !tags.includes(tag)){
            if(tags.length < 10){
                tag.split(',').forEach(tag => {
                    tags.push(tag);
                    createTag();
                });
            }
        }
        e.target.value = "";
    }
}




// تبدیل آرایه تگ‌ها به یک رشته
// const tagsStr = tags.join(",");

// console.log(tagsStr);

// ارسال رشته تگ‌ها به صفحه PHP
// $.ajax({
//     url: "tpl/action-index.php",
//     method: "post",
//     data: {
//         tags: tagsStr
//     }
// });


// // دریافت مقادیر تگ‌های li
// const lis = ul.querySelectorAll("li");

// for (let li of lis) {
//     tags.push(li.getAttribute("value"));
// }

// // اضافه کردن مقادیر تگ‌ها به آرایه داده‌های فرم
// const data = {};
// data.tags = tags;

// // ارسال داده‌های فرم به صفحه action-index
// const xhr = new XMLHttpRequest();
// xhr.open("POST", "tpl/action-index.php");
// xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
// xhr.send(JSON.stringify(data));

