const imgsrc = "/assets/images/js.png";

console.log("console aaa");

// jsから画像を読み込むサンプル
const canvas = document.querySelector("#canvas");
const context = canvas.getContext("2d");
const image = new Image(300, 300);
image.src = imgsrc;
image.addEventListener("load", () => {
  context?.drawImage(image, 0, 0, 300, 300);
});
