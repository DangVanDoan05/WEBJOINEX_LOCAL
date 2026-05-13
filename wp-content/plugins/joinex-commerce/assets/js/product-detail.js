//#region thuộc tính phần thư viện hình ảnh sản phẩm
document.addEventListener("DOMContentLoaded", function () {
  const mainImage = document.getElementById("current-main-image");
  const thumbs = document.querySelectorAll(".thumb-image");
  const slider = document.querySelector(".images-gallery-product.slider");
  const btnPrev = document.querySelector(".btn-prev");
  const btnNext = document.querySelector(".btn-next");

  let currentIndex = 0; // ảnh đang active
  let startIndex = 0; // ảnh đầu tiên trong khung
  const maxVisible = 4; // số thumbnail hiển thị

  function showImage(index) {
    mainImage.src = thumbs[index].src.replace("-150x150", "");
    thumbs.forEach((t) => t.classList.remove("active"));
    thumbs[index].classList.add("active");
    currentIndex = index;
  }

  function updateSlider() {
    // dịch slider theo startIndex
    const thumbWidth = thumbs[0].offsetWidth;
    slider.scrollTo({
      left: startIndex * thumbWidth,
      behavior: "smooth",
    });
  }

  btnNext.addEventListener("click", () => {
    if (currentIndex < thumbs.length - 1) {
      currentIndex++;
      // nếu active vượt quá khung hiển thị thì dịch startIndex
      if (currentIndex >= startIndex + maxVisible) {
        startIndex++;
        updateSlider();
      }
      showImage(currentIndex);
    }
  });

  btnPrev.addEventListener("click", () => {
    if (currentIndex > 0) {
      currentIndex--;
      // nếu active nhỏ hơn startIndex thì dịch startIndex ngược lại
      if (currentIndex < startIndex) {
        startIndex--;
        updateSlider();
      }
      showImage(currentIndex);
    }
  });

  // click trực tiếp thumbnail
  thumbs.forEach((thumb, index) => {
    thumb.addEventListener("click", () => {
      showImage(index);
    });
  });

  // khởi tạo
  showImage(currentIndex);
  updateSlider();
});
//#endregion

// #region JS CHO PHẦN TÙY CHỌN THUỘC TÍNH

document.addEventListener('DOMContentLoaded', function() {
    const priceBox = document.getElementById('block-price');

    if (typeof variationData !== 'undefined') {
        function updatePrice() {
            const selectedAttrs = {};
            document.querySelectorAll('.attr-btn.active').forEach(activeBtn => {
                selectedAttrs[activeBtn.dataset.attrName] = activeBtn.dataset.attr;
            });

            for (const id in variationData)
               {
                const attrs = variationData[id].attributes;
                let match = true;
                for (const key in selectedAttrs) {
                    if (attrs[key] != selectedAttrs[key]) {
                        match = false;
                        break;
                    }
                }
                if (match) {
                    const salePrice = variationData[id].sale_price;
                    const regularPrice = variationData[id].regular_price;

                    if (salePrice && salePrice !== "") {
                        priceBox.innerHTML = `
                            <span class="sale-price">${new Intl.NumberFormat('vi-VN',{style:'currency',currency:'VND'}).format(salePrice)}</span>
                            <span class="regular-price">${new Intl.NumberFormat('vi-VN',{style:'currency',currency:'VND'}).format(regularPrice)}</span>
                        `;
                    } else {
                        priceBox.innerHTML = `
                            <span class="regular-price-no-sale">${new Intl.NumberFormat('vi-VN',{style:'currency',currency:'VND'}).format(regularPrice)}</span>
                        `;
                    }
                    return;
                }
            }
        }

        document.querySelectorAll('.button-variation-container').forEach(group => {
            const buttons = group.querySelectorAll('.attr-btn');
            buttons.forEach(btn => {
                btn.addEventListener('click', function() {
                    buttons.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    updatePrice();
                });
            });
        });
    }
});




//#endregion

//#region JS CHO PHẦN NÚT BẤM.
document.addEventListener("DOMContentLoaded", function () {
  console.log("✅ JS joinex PHẦN CHỌN SỐ LƯỢNG SẢN PHẨM đã load và đang chạy!");

  const qtyInput = document.querySelector(".qty-input-joinex");
  const minusBtn = document.querySelector(".minus-joinex");
  const plusBtn = document.querySelector(".plus-joinex");

  minusBtn.addEventListener("click", function () {
    let value = parseInt(qtyInput.value);
    if (value > 1) qtyInput.value = value - 1;
    console.log("Số lượng sau khi trừ:", qtyInput.value);
  });

  plusBtn.addEventListener("click", function () {
    let value = parseInt(qtyInput.value);
    qtyInput.value = value + 1;
    console.log("Số lượng sau khi cộng:", qtyInput.value);
  });
});
//#endregion

//#region   MÔ TẢ DÀI SẢN PHẨM

document.addEventListener("DOMContentLoaded", function () {
  const tabs = document.querySelectorAll(".tab-link-joinex");
  const panes = document.querySelectorAll(".tab-pane-joinex");

  tabs.forEach((tab) => {
    tab.addEventListener("click", function () {
      // bỏ active cũ
      tabs.forEach((t) => t.classList.remove("active"));
      panes.forEach((p) => p.classList.remove("active"));

      // thêm active mới
      this.classList.add("active");
      const target = this.getAttribute("data-tab");
      document.getElementById(target).classList.add("active");
    });
  });
});

//#endregion
