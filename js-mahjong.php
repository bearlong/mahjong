<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script>
    const asideLink = document.querySelectorAll(".sidebar ul .main-sidebar");
    const arrow = document.querySelectorAll(".arrow");
    const subSidebarSwitch = document.querySelectorAll(".sub-sidebar-switch");
    const subLabelUl = document.querySelectorAll(".sub-label-ul");


    for (let i = 0; i < asideLink.length; i++) {
        asideLink[i].addEventListener("click", function() {
            let group = this.dataset.group;

            $.ajax({
                    method: "POST", //or GET
                    url: "http://localhost/mahjong/navApi.php",
                    dataType: "json",
                    data: {
                        group: group,
                    },
                })
                .done(function(response) {
                    console.log(response);
                }).fail(function(jqXHR, textStatus) {
                    console.log("Request failed: " + textStatus);
                });
            arrow[i].classList.toggle("active");
        });
    }

    for (let i = 0; i < subSidebarSwitch.length; i++) {
        subSidebarSwitch[i].addEventListener("click", function() {
            for (let j = 0; j < asideLink.length; j++) {
                arrow[j].classList.remove("d-inline");
                asideLink[j].classList.remove("active");
            }
            console.log("click");
            arrow[i].classList.add("d-inline");
            subSidebarSwitch[i].classList.add("active");
            subLabelUl[i].classList.toggle("sub-label-ul-active");
        });

    }
</script>