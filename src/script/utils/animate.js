class Animate {
  static async left(obj, from, to) {
    if (from >= to) {
      obj.style.visibility = "hidden";
      return;
    } else {
      var box = obj;
      box.style.marginLeft = from + "px";
      setTimeout(function () {
        Animate.left(obj, from + 1, to);
      }, 1);
    }
  }
}

export default Animate;
