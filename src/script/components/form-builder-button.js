class FormBuilderButton extends HTMLElement {
  constructor() {
    super();
  }

  connectedCallback() {
    this.render();
  }

  render() {
    this.innerHTML = `
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    :host {
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    </style>
    <button type="submit" class="btn btn-gradient-primary mr-2">Simpan</button>
    `;
  }
}

customElements.define("form-builder-button", FormBuilderButton);
