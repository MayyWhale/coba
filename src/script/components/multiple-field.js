import Animate from "../utils/animate.js";

class MultipleField extends HTMLElement {
  constructor() {
    super();
    this._original = [];
  }

  set attr(attr) {
    this._attr = attr;
    this.render();
  }

  connectedCallback() {
    this.render();
  }

  attributeChangedCallback(name, oldValue, newValue) {}

  static get observedAttributes() {
    return [];
  }

  renderFields(value) {
    let row = document.createElement("div");
    let row2 = document.createElement("div");
    let col = document.createElement("div");
    let btn = document.createElement("div");
    row.setAttribute("class", `row`);
    row2.setAttribute("class", `row`);
    col.setAttribute("class", `col-10`);
    btn.setAttribute("class", `col-2 p-1 d-flex justify-content-center align-items-center`);
    btn.innerHTML = `
    <a role="button" class="btn btn-danger p-2 multifield-delete"><i class="mdi mdi-delete"></i></a>
    <a role="button" class="btn btn-info p-2 multifield-edit"><i class="mdi mdi-pencil"></i></a>
    `;
    const deleteBtn = $(btn).find(".multifield-delete");
    const editBtn = $(btn).find(".multifield-edit");
    editBtn.hide();
    let id;
    const obj = {};
    if (value) {
      value.forEach((field, i) => {
        let content;
        if (field.type != "hidden") {
          content = document.createElement("div");
          content.setAttribute("class", `col-sm p-1`);

          let formFieldEl = document.createElement("modal-input");
          formFieldEl.field = field;

          content.append(formFieldEl); // set original value

          obj[field.name] = field.value;
        } else {
          id = field.value;
          content = document.createElement("modal-input");
          content.field = field;
        }
        row2.append(content);
      });
      this._original[id] = obj;
    } else {
      this._attr.inputs.forEach((field, i) => {
        let content = document.createElement("div");
        content.setAttribute("class", `col-sm p-1`);

        let formFieldEl = document.createElement("modal-input");
        field.name = `${field.name}`;
        formFieldEl.field = field;

        content.append(formFieldEl);
        row2.append(content);
      });
    }
    col.append(row2);
    row.append(col);
    btn.querySelector(".multifield-edit").addEventListener("click", async (multifieldEdit) => {
      let saveEl;
      if (multifieldEdit.target.tagName == "I") {
        saveEl = multifieldEdit.target.parentElement.parentElement.parentElement;
      } else {
        saveEl = multifieldEdit.target.parentElement.parentElement;
      }
      if (this._attr.saveUrl) {
        const values = this.validateInput(saveEl);
        if (!values) {
          alert("Semua field harus diisi");
          return;
        }
        const result = await this.saveResult(values);
        console.log(result);
      }

      $(saveEl)
        .find(".multifield-edit")
        .slideUp(400, () => {
          $(saveEl).find(".multifield-edit").hide();
          $(saveEl).find(".multifield-delete").slideDown();
        });
    });
    btn.querySelector(".multifield-delete").addEventListener("click", async (multifieldDelete) => {
      let delEl;
      if (multifieldDelete.target.tagName == "I") {
        delEl = multifieldDelete.target.parentElement.parentElement.parentElement;
      } else {
        delEl = multifieldDelete.target.parentElement.parentElement;
      }

      if (!this._attr.saveUrl) {
        $(delEl).slideUp(400, () => delEl.remove());
        return;
      }
      const keywordId = $(delEl).find(`[name="${this._attr.nameKey}"]`).val();
      const result = await this.deleteResult({ keyword: keywordId });
      if (!keywordId) {
        alert("Field tambah data Tidak dapat dihapus saat mode edit");
        return;
      }
      if (result) {
        console.log(result);
        $(delEl).slideUp(400, () => delEl.remove());
        return;
      }
    });
    if (value) {
      const inputs = row.querySelectorAll(".form-control");
      for (let i = 0; i < inputs.length; i++) {
        inputs[i].addEventListener("input", async (input) => {
          deleteBtn.slideUp(400, () => {
            deleteBtn.hide();
            editBtn.slideDown();
          });
        });
      }
    }
    row.append(btn);
    return row;
  }

  render() {
    this.innerHTML = `
    <div class="card mb-4">
      <div class="card-header">
        Featured
      </div>
      <div class="card-body">
        <div class="multifield-body">
        </div>
        <div class="text-center">
          <a role="button" class="btn btn-gradient-primary mr-2 multifield-add">Tambah</a>
        </div>
      </div>
    </div>
      `;
    if (this._attr) {
      this.querySelector(".card-header").innerText = this._attr.label;
      this.querySelector(".multifield-body").innerHTML = "";
    }
    if (this._attr.value.length > 0) {
      this._attr.value.forEach((field, i) => {
        const newEl = this.renderFields(field);
        $(newEl).hide();
        this.querySelector(".multifield-body").append(newEl);
        $(newEl).slideDown();
      });
      const newEl = this.renderFields();
      $(newEl).hide();
      this.querySelector(".multifield-body").append(newEl);
      $(newEl).slideDown();
    }

    this.querySelector(".multifield-add").addEventListener("click", async (e) => {
      if (!this._attr.saveUrl) {
        const newEl = this.renderFields();
        $(newEl).hide();
        this.querySelector(".multifield-body").append(newEl);
        $(newEl).slideDown();
        return;
      }
      const addRow = this.querySelector(".multifield-body").lastChild;
      const values = this.validateInput(addRow);
      if (!values) {
        alert("Bidang yang kosong harus diisi");
        return;
      }
      const result = await this.saveResult(values);
      if (!result) {
        alert("Gagal!");
        return;
      }
      $(addRow).slideUp(400, () => {
        $(addRow).remove();
        const newEl = this.renderFields(result.fields);
        const newElEmpty = this.renderFields();
        $(newEl).hide();
        this.querySelector(".multifield-body").append(newEl);
        $(newEl).slideDown();
        $(newElEmpty).hide();
        this.querySelector(".multifield-body").append(newElEmpty);
        $(newElEmpty).slideDown();
      });
    });
  }

  async saveResult(data) {
    if (!this._attr.saveUrl) {
      return false;
    }
    return fetch(this._attr.saveUrl, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
    })
      .then((response) => response.json())
      .then((data) => {
        return data;
      })
      .catch((error) => {
        return error;
      });
  }

  async deleteResult(data) {
    if (!this._attr.deleteUrl || !data.keyword) {
      return false;
    }
    return fetch(this._attr.deleteUrl, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
    })
      .then((response) => response.json())
      .then((data) => {
        return data;
      })
      .catch((error) => {
        return error;
      });
  }

  validateInput(elements) {
    const inputs = elements.querySelectorAll("input, select, checkbox, textarea");
    const values = {};
    for (const inputE of inputs) {
      values[inputE.name.replace("[", "").replace("]", "")] = inputE.value.trim();
      if (inputE.value.trim() == "") {
        return false;
      }
    }
    return values;
  }
}

customElements.define("multiple-field", MultipleField);
