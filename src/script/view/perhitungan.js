import "../components/comparison-range.js";
import "../utils/loader-spinner.js";
import DataSource from "../data/data-source.js";

const perhitungan = (utils) => {
  console.log(`init ${page} page.....`);
  const contentWrapper = $("#content-wrapper");
  const formWrapper = $("#form-hitung");

  pageContentGenerator();

  async function pageContentGenerator() {
    try {
      formWrapper.html(`<loader-spinner></loader-spinner>`);
      const result = await DataSource.pagePerhitungan();
      contentWrapper.find(".card-header-text").text(result.title);
      formWrapper.attr(`action`, result.url);
      if (result.messages) {
        contentWrapper.find(".card-header-text").text(result.messages.title);
        formWrapper.html(`<div class="alert alert-warning" role="alert">${result.messages.text}</div>`);
      } else {
        if (result.inputs.length > 0) {
          formWrapper.html(``);
          result.inputs.map((input) => {
            let el = document.createElement("comparison-range");
            el.features = input;
            console.log(el);
            formWrapper.append(el);
          });
          formWrapper.append(`<div class="text-center"><button type="submit" class="btn btn-gradient-primary mr-2">Simpan</button></div>`);
        }
      }
    } catch (message) {
      formWrapper.html(``);
    }
  }

  // const renderResult = (results) => {
  //   const formBuilderEl = document.querySelector("form-builder");
  //   formBuilderEl.mode = results.mode ?? "normal";
  //   formBuilderEl.fields = results.fields ?? [];
  //   formBuilderEl.hrefurl = results.url ?? "";
  // };

  // const fallbackResult = (message) => {
  //   const formBuilderEl = document.querySelector("form-builder");
  //   formBuilderEl.renderError(message);
  // };

  // pilihJurusanButton.on("click", onPilihJurusanModalButtonClicked);
};

export default perhitungan;
