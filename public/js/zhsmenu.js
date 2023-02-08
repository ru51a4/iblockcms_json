class zhsmenu {
    menu = {};

    constructor(menu) {
        this.menu = menu;
    }

    init(selector) {
        let menu = this.menu;
        let getParrent = (node, prev) => {
            node.parrent = prev?.title;
            node?.childrens.forEach((item) => {
                getParrent(item, node);
            })
        };
        getParrent(menu);

        let html = `<div class="zhs-menu">
                <div class="zhs-menu--items">`;
        let t = [];
        let cLvl = 1;
        let queue = [...menu.childrens];
        while (queue.length) {
            let item = queue.shift();
            let displaynone = (cLvl > 1) ? 'display:none' : ''
            let next = (item.childrens.length) ? "->" : "";
            let url = item?.url?.length ? item?.url : '#';
            html += `
                <div lvl="${cLvl}" data="${item.title}" parrent="${item.parrent}" style="${displaynone}" class="zhs-menu--items--item">
                    <a href="${url}">
                        ${item.title}
                        ${next}
                    </a>
                </div>
                `;
            t.push(...item.childrens);
            if (!queue.length) {
                queue.push(...t);
                html += `</div>`;
                if (t.length) {
                    html += `<div class="zhs-menu--items">`;
                }
                t = [];
                cLvl++
            }
        }
        let maxLvl = cLvl;
        html += "</div>"
        document.querySelector(selector).innerHTML = html;
        document.querySelectorAll(".zhs-menu--items--item").forEach((el) => {
            el.addEventListener("mousemove", (item) => {
                let data = el.getAttribute("data");
                document.querySelectorAll(`[parrent="${data}"]`)[0].parentElement.style.marginTop = (el.offsetTop-1)+"px";
                let lvl = document.querySelectorAll(`[parrent="${data}"]`)[0].getAttribute("lvl");

                for (let i = parseInt(lvl); i <= maxLvl; i++) {
                    document.querySelectorAll(`[lvl="${i}"]`).forEach((el) => {
                        el.style.display = "none";
                    });
                }
                document.querySelectorAll(`[parrent="${data}"]`).forEach((el) => {
                    el.style.display = "inline";
                })
            });
        })
    }
}
