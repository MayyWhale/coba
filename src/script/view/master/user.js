import "../../utils/loader-spinner.js";
import "../../components/form-builder.js";
import DataSource from "../../data/data-source.js";

const user = (utils) => {
  console.log(`init ${page} page.....`);

  const addButton = $("#addUserButton");
  addButton.on("click", () => {
    utils.myModal.id = null;
    onUserClicked();
  });
  $("body").on("click", ".edit-button", (event) => {
    utils.myModal.id = event.currentTarget.id;
    console.log(event.currentTarget.id, event);
    onUserClicked();
  });

  const onUserClicked = async () => {
    utils.myModal.title.text("Tambah User");
    utils.myModal.body.html(`<loader-spinner></loader-spinner>`);
    utils.myModal.modal.toggle();
    try {
      const result = await DataSource.formUser(utils.myModal.id ?? null);
      utils.myModal.body.html(`<form-builder></form-builder>`);
      console.log(result);
      renderResult(result);
    } catch (message) {
      utils.myModal.body.html(`<form-builder></form-builder>`);
      fallbackResult(message);
    }
  };

  const renderResult = (results) => {
    const formBuilderEl = document.querySelector("form-builder");
    formBuilderEl.mode = results.mode ?? "normal";
    formBuilderEl.fields = results.fields ?? [];
    formBuilderEl.hrefurl = results.url ?? "";
  };

  const fallbackResult = (message) => {
    const formBuilderEl = document.querySelector("form-builder");
    formBuilderEl.renderError(message);
  };
};

export default user;
