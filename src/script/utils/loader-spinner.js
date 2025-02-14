class LoaderSpinner extends HTMLElement {
  constructor() {
    super();
    this.shadowDOM = this.attachShadow({ mode: "open" });
  }

  connectedCallback() {
    this.render();
  }

  attributeChangedCallback(name, oldValue, newValue) {
    this.updateStyle(this);
  }

  static get observedAttributes() {
    return ["color", "box"];
  }

  updateStyle(elem) {
    this.shadowDOM.querySelector("style").textContent = `
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
    .lds-roller {
        display: inline-block;
        width: 80px;
        height: 80px;
        margin: ${elem.getAttribute("box") ?? "10px"};
    }
      .lds-roller div {
        animation: lds-roller 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        transform-origin: 40px 40px;
    }
      .lds-roller div:after {
        content: " ";
        display: block;
        position: absolute;
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: ${elem.getAttribute("color") ?? "#000"};
        margin: -4px 0 0 -4px;
    }
    .lds-roller div:nth-child(1) {
        animation-delay: -0.036s;
    }
    .lds-roller div:nth-child(1):after {
        top: 63px;
        left: 63px;
    }
      .lds-roller div:nth-child(2) {
          animation-delay: -0.072s;
    }
      .lds-roller div:nth-child(2):after {
          top: 68px;
        left: 56px;
    }
      .lds-roller div:nth-child(3) {
          animation-delay: -0.108s;
    }
      .lds-roller div:nth-child(3):after {
          top: 71px;
        left: 48px;
    }
      .lds-roller div:nth-child(4) {
          animation-delay: -0.144s;
    }
      .lds-roller div:nth-child(4):after {
          top: 72px;
        left: 40px;
    }
      .lds-roller div:nth-child(5) {
          animation-delay: -0.18s;
    }
      .lds-roller div:nth-child(5):after {
          top: 71px;
        left: 32px;
    }
      .lds-roller div:nth-child(6) {
          animation-delay: -0.216s;
    }
      .lds-roller div:nth-child(6):after {
          top: 68px;
        left: 24px;
    }
      .lds-roller div:nth-child(7) {
          animation-delay: -0.252s;
    }
      .lds-roller div:nth-child(7):after {
          top: 63px;
        left: 17px;
    }
      .lds-roller div:nth-child(8) {
          animation-delay: -0.288s;
    }
      .lds-roller div:nth-child(8):after {
          top: 56px;
        left: 12px;
    }
    @keyframes lds-roller {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
    `;
  }

  render() {
    this.shadowDOM.innerHTML = `
    <style>
    </style>
    <div class="lds-roller">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
      `;
    this.updateStyle(this);
  }
}

customElements.define("loader-spinner", LoaderSpinner);
