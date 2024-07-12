<template>
    <div class="form__create">
      <div class="container">
        <h2 class="title">Создание страницы курса</h2>
  
        <div class="form__create-inner">
          <button class="btn--add" @click="searchVisible = !searchVisible">
            {{ (searchVisible) ? "-" : "+" }}
          </button>
          <div class="search" v-if="searchVisible">
            <input type="text" class="input" placeholder="Поиск" v-model="searchBtn">
            <ul class="search__list">
              <li class="search__item" @click="create(item)" v-for="item in computedSearchList" :key="item.id">{{ item.title }}</li>
            </ul>
          </div>
          
          <input type="text" class="input input--title" placeholder="Добавить заголовок">
          <!-- Динамически добавляемые элементы -->
          <div ref="formCreateInner"></div>
  
        </div>
        <button class="btn" @click="createdPage">Добавить</button>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, computed, onMounted } from "vue"
  import { useStore, mapState, mapGetters, mapMutations } from 'vuex';
  const store = useStore();
  
  const searchVisible = ref(false)
  const searchBtn = ref("")
  
  const searchList = ref([
    { id: 1, placeholder: "Заголовок h1", title: "Заголовок_1", name: "h1" },
    { id: 2, placeholder: "Заголовок h2", title: "Заголовок_2", name: "h2" },
    { id: 3, placeholder: "Заголовок h3", title: "Заголовок_3", name: "h3" },
    { id: 4, placeholder: "Заголовок h4", title: "Заголовок_4", name: "h4" },
    { id: 5, placeholder: "Заголовок h5", title: "Заголовок_5", name: "h5" },
    { id: 6, placeholder: "Абзац", title: "Абзац", name: "textarea" },
    { id: 7, placeholder: "Ссылку", title: "Ссылка", name: "a", meta: {
      placeholder: "Название ссылки", name: "value"
    } },
    { id: 8, placeholder: "Список", title: "Список", name: "ul", },
    // { id: 9, placeholder: "Таблица", title: "Таблица", name: "table", },
    // Изображение данные с сервера и можно свое
    // Видео данные с сервера и можно свое
  ])
  
  const formCreateInner = ref(null)
  const inputValue = ref("")
  const countBtn = ref(0)
  
  const create = (item) => {
    countBtn.value += 1
    const div = document.createElement("div");
    div.classList.add("drop__zone");
    div.setAttribute("draggable", "true");
    div.addEventListener("dragstart", (event) => handleDragStart(event, div));


    if (item.name === "table") {
      const table = document.createElement("div")
      table.classList.add("table")
  
      const tableCol = document.createElement("div")
      const tableColBtn = document.createElement("button") 
      tableColBtn.classList.add("btn")
      tableCol.appendChild(tableColBtn)
  
      tableCol.classList.add("table__column")
      tableColBtn.addEventListener("click", () => {
        const tableColInput = document.createElement("textarea")
        tableColInput.classList.add("input")
        tableColInput.placeholder = "Введите текст"
        tableCol.appendChild(tableColInput)
      })
      table.appendChild(tableCol)
      const tableColHeight = document.createElement("button")  
      tableColHeight.classList.add("btn")
      tableColHeight.innerHTML = "+"
      tableCol.appendChild(tableColHeight)
  
      div.append(table)
      formCreateInner.value.appendChild(div)
      return
    }
  
    else if (item.name === "ul") {
      const mainList = document.createElement("ul")
      mainList.classList.add("list__form-create")
      const btnCreate = document.createElement("button")
      btnCreate.classList.add("btn")
      btnCreate.innerHTML = "Добавить элемент"
      const createItem = (parent) => {
        const item = document.createElement("li")
        const itemInput = document.createElement("textarea")
        itemInput.classList.add("input")
        itemInput.placeholder = "Введите текст"
        itemInput.addEventListener("input", (event) => {
          inputValue.value = event.target.value // Обновление реактивного состояния
          itemInput.style.height = "auto"
          itemInput.style.height = `${itemInput.scrollHeight}px`
        })
      item.appendChild(itemInput)
      const createBtnInnerListLi = document.createElement("li")
      const createBtnInnerList = document.createElement("button")
      createBtnInnerList.classList.add("btn")
      createBtnInnerList.innerHTML = "Создать вн. список"
      createBtnInnerListLi.appendChild(createBtnInnerList)
      item.appendChild(createBtnInnerListLi)
      createBtnInnerList.addEventListener("click", () => {
        createList(item)
      })
      parent.appendChild(item)
    }
    const createList = (parent, classListName = "list") => {
      const list = document.createElement("ul")
      list.classList.add(classListName)
      const itemLi = document.createElement("li")
      const itemBtnLi = document.createElement("button")
      itemBtnLi.classList.add("btn")
      itemBtnLi.innerHTML = "Добавить элемент"
      itemLi.prepend(itemBtnLi)
      list.appendChild(itemLi)
      const itemBtnUlLi = document.createElement("li")
      const createBtnInnerList = document.createElement("button")
      createBtnInnerList.classList.add("btn")
      createBtnInnerList.innerHTML = "Создать вн. список"
      itemBtnUlLi.appendChild(createBtnInnerList)
      list.appendChild(itemBtnUlLi)
      createBtnInnerList.addEventListener("click", () => {
          createList(list, "list__list")
      })
      itemBtnLi.addEventListener("click", () => {
          createItem(list)    
      })
      parent.appendChild(list)
    }
    btnCreate.addEventListener("click", () => {
      createItem(mainList)
    })
    mainList.appendChild(btnCreate)
    mainList.dataset.dom = item.name
    div.append(mainList)
    formCreateInner.value.appendChild(div)
    return
  }
  
  
    else if (item.name === "a") {
      const link = document.createElement("input")
      link.classList.add("input")
      link.placeholder = `Введите ${item.placeholder}`
  
      const linkMeta = document.createElement("input")
      linkMeta.classList.add("input")
      linkMeta.placeholder = `${item.meta.placeholder}`
      link.addEventListener("input", (event) => {
        inputValue.value = event.target.value; // Обновление реактивного состояния
      });
      linkMeta.addEventListener("input", (event) => {
        inputValue.value = event.target.value; // Обновление реактивного состояния
      });
      link.dataset.dom = item.name
      div.appendChild(link)
      linkMeta.dataset.dom = item.meta.name
      div.appendChild(linkMeta)
      formCreateInner.value.appendChild(div)
      return
    }
  
  
    else if (item.name[0] === "h") {
      const title = document.createElement("input")
      title.classList.add("input")
      title.placeholder = `Введите ${item.placeholder}`
      title.addEventListener("input", (event) => {
        inputValue.value = event.target.value; // Обновление реактивного состояния
      });
      title.style.fontSize = (item.name == "h1")
        ? "32px" : (item.name == "h2")
          ? "24px" : (item.name == "h3")
            ? "19px" : (item.name == "h4")
              ? "16px" : (item.name == "h5")
                ? "14px" : (item.name == "h6")
                  ? "12px" : "1rem";
      title.dataset.dom = item.name
      div.appendChild(title)
      formCreateInner.value.appendChild(div)
    }
  
  
    else if (item.name == "textarea") {
      const textarea = document.createElement("textarea")
      textarea.classList.add("input")
      textarea.placeholder = `Введите ${item.placeholder}`
      textarea.addEventListener("input", (event) => {
        inputValue.value = event.target.value // Обновление реактивного состояния
        textarea.style.height = "auto"
        textarea.style.height = `${textarea.scrollHeight}px`
      })
      textarea.dataset.dom = item.name
      div.appendChild(textarea)
      formCreateInner.value.appendChild(div)
    } else {
      return
    }
  }
  
  const draggedItem = ref(null)
  // const draggedListItem = ref(null)
  
  const handleDragStart = (event, item) => {
    draggedItem.value = item
    event.dataTransfer.effectAllowed = "move"
  }
  
  // const handleListItemDragStart = (event, listItem) => {
  //   draggedListItem.value = listItem
  //   event.dataTransfer.effectAllowed = "move"
  // }
  
  const handleDrop = (event) => {
    event.preventDefault()
    const dropZones = Array.from(formCreateInner.value.children)
    const targetItem = event.target.closest(".drop__zone")
    if (draggedItem.value && targetItem && draggedItem.value !== targetItem) {
      const targetIndex = dropZones.indexOf(targetItem)
      const draggedIndex = dropZones.indexOf(draggedItem.value)
      if (targetIndex > draggedIndex) {
        formCreateInner.value.insertBefore(draggedItem.value, targetItem.nextSibling)
      } else {
        formCreateInner.value.insertBefore(draggedItem.value, targetItem)
      }
    }
    draggedItem.value = null
  }
  
  // const handleListItemDrop = (event, listItem) => {
  //   event.preventDefault()
  //   const list = listItem.closest("ul")
  //   const listItems = Array.from(list.children).filter(child => child.classList.contains("item"))
  //   if (draggedListItem.value && listItem && draggedListItem.value !== listItem) {
  //     const targetIndex = listItems.indexOf(listItem)
  //     const draggedIndex = listItems.indexOf(draggedListItem.value)
  //     if (targetIndex > draggedIndex) {
  //       list.insertBefore(draggedListItem.value, listItem.nextSibling)
  //     } else {
  //       list.insertBefore(draggedListItem.value, listItem)
  //     }
  //   }
  //   draggedListItem.value = null
  // }
  
  onMounted(() => {
    formCreateInner.value.addEventListener("dragover", (event) => event.preventDefault())
    formCreateInner.value.addEventListener("drop", handleDrop)
  })
  
  const computedSearchList = computed(() => {
    return (!searchBtn.value.length)
      ? searchList.value
      : searchList.value.filter((e) =>
        e.title.toLowerCase().includes(searchBtn.value.toLowerCase().trim())
      )
  })
  
  const createdPage = () => {
  let newStr = "";

  const getListHTML = (ul) => {
    if (!ul || ul.tagName !== 'UL') {
      throw new Error('The provided element is not a UL');
    }

    const traverseList = (node) => {
      let htmlString = '<ul>';

      node.childNodes.forEach(child => {
        if (child.tagName === 'LI') {
          const textContent = child.firstChild?.value || child.firstChild?.textContent || '';

          // Пропускаем элементы с текстом "Добавить элемент" и "Создать вн. список"
          if (textContent === 'Добавить элемент' || textContent === 'Создать вн. список') {
            return;
          }

          htmlString += '<li>' + textContent;

          const nestedUl = Array.from(child.children).find(nestedChild => nestedChild.tagName === 'UL');
          if (nestedUl) {
            htmlString += traverseList(nestedUl);
          }

          htmlString += '</li>';
        }
      });

      htmlString += '</ul>';
      return htmlString;
    };

    return traverseList(ul);
  };

  formCreateInner.value.childNodes.forEach((e) => {
    const nameDom = e.firstChild.dataset["dom"];
    if (nameDom === "ul") {
      newStr += getListHTML(e.firstChild);
      newStr += "<br/>";
    }
    else if (nameDom === "a") {
      let value, link;
      for (const item of e.children) {
        if (item.dataset["dom"] === "value") { value = item.value; }
        else if (item.dataset["dom"] === "a") { link = item.value; }
      }
      newStr += `<a href="${link}">${value}</a><br/>`;
    }
    else if (nameDom == "textarea") {
      newStr += `<p>${e.firstChild.value}</p><br/>`;
    } else {
      newStr += `<${nameDom}>${e.firstChild.value}</${nameDom}><br/>`;
    }
  });

  console.log("33333333333333", newStr);
//   return newStr;
    const name = document.querySelector(".input--title")
    const user = computed(() => store.state.user)
    const data = {
      user_id: user.value["id"],
      name: name.value,
      html: newStr, 
    }
    console.log('dadta', data)
    const coursePost = async (data) => {
      try {
        const response = await axios.post("api/course", data)
        console.log(response)
      } catch (err) {
        console.log(err)
      }
    }
    console.log(coursePost(data))
};
  </script>
  
  <style>
  .drop__zone {
  padding: 10px;
  border: 2px solid #ccc;
  margin-bottom: 20px;
  }
  .drop__zone + .drop__zone {
  margin: 10px 0 0 0; 
  }
  .search {
  border: 1px solid #ccc;
  padding: 10px;
  max-width: 700px;
  width: 100%;
  }
  .search__list {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  }
  .search__item {
  font-weight: 600;
  cursor: pointer;
  }
  .list__form-create {
    display: flex;
    flex-direction: column;
    /* gap: 5px; */
    align-items: flex-start;
  }
  .list__form-create .item {
    width: 100%;
    cursor: move;
    border-bottom: 1px solid #ccc;
  }
  .list__form-create ul {
    border-left: 1px solid #ccc;
  }
  .list__form-create li {
    /* border-left: 1px solid #ccc; */
    /* border-right: 1px solid #ccc; */
    padding: 5px;
  }
  /* .list__form-create ul,
  .list__form-create .list__list {
    border: 1px solid #ccc;
    padding: 10px;
  } */
  ul > ul,
  ul > li >  ul {
    margin-left: 20px;
  }
  textarea {
  width: 300px;
  /* height: 100px; */
  resize: none;
  font-family: inherit;
  font-weight: 600;
  text-align: justify;
  resize: none;
  overflow: hidden;
  font-size: 1rem;
  }
  .table {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
  }
  .table__column {
    display: flex;
    flex-direction: row;
    gap: 5px;
    padding: 10px;
    border: 1px solid #ccc;
    width: 100%;
  }
  .btn {
    display: block;
    cursor: pointer;
    padding: 10px;
    border: 1px solid #ccc;
    background-color: transparent;
  }
  .input {
  font-weight: 800;
  background-color: transparent;
  width: 100%;
  color: var(--clr-text);
  border: none;
  outline: none;
  padding: 10px 0;
  font-size: 1rem;
  }
  .input--title {
  font-size: 2rem;
  }
  .btn--add {
  width: 40px;
  padding: 5px;
  border-radius: var(--border-radius);
  background-color: var(--clr-text);
  color: var(--clr-bg);
  cursor: pointer;
  border: none;
  }
  input::placeholder {
    color: var(--clr-text);
    text-transform: uppercase;
  }
  </style>