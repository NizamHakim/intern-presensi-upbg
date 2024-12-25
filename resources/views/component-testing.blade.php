<x-layouts.user-layout>
    <x-slot:title>Testing</x-slot>
    <div id="container" class="flex w-full flex-row flex-wrap gap-2">
        <div class="flex-1 truncate">
            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ut consequuntur minima eaque delectus fugit,
            doloremque dolor quibusdam nihil earum itaque nesciunt ea ullam? Iusto animi, sapiente alias magni assumenda
            maxime?
        </div>
        <div class="flex-1 truncate">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Officia, fugit aliquam perspiciatis dolores
            impedit iste doloremque eaque atque molestias deleniti. Earum dolorem omnis enim magnam facere labore totam
            culpa quibusdam, praesentium adipisci unde autem? Voluptas mollitia, nulla voluptates corrupti in
            praesentium aut reprehenderit omnis blanditiis quas dolore iusto laboriosam ipsa quasi, ullam labore minima,
            soluta voluptatum maiores tenetur. Sequi amet recusandae exercitationem esse in, neque rem molestiae dolorum
            excepturi necessitatibus! Reiciendis quibusdam quaerat dolores officia mollitia voluptas eos error
            excepturi, et incidunt consequuntur rerum aliquam veritatis labore. Dolor at, dolorum quo provident dolores
            ut dolorem consectetur atque, neque alias dolore odio deleniti magni quos doloremque repudiandae consequatur
            voluptate nesciunt perspiciatis error perferendis quidem? Necessitatibus, ad. Repellendus blanditiis neque
            similique quas! Fugiat necessitatibus tenetur dolore cupiditate officiis repellendus exercitationem corporis
            facilis doloribus numquam hic optio, illo sunt voluptates ratione, fuga velit? Nesciunt, provident eius
            cupiditate aliquid harum sequi corrupti nisi quas ea nam, quasi ab? Veritatis fuga voluptate iusto iste,
            voluptatibus nobis! Ratione cum adipisci quisquam, vel aliquid perferendis dignissimos maxime est magni
            quasi provident necessitatibus distinctio illo ipsam sequi commodi numquam dolores tempora esse qui quas ab
            temporibus? Adipisci, quisquam, commodi quam odio esse, iure hic reiciendis consequuntur sed at culpa
            maxime? Non voluptas a officia tenetur ratione, error saepe aliquid distinctio, sit totam architecto eveniet
            modi molestiae et! Voluptatum, cupiditate consequuntur officiis animi aliquam quae ut hic voluptate id est
            voluptatem vero earum delectus odio ea sunt. Necessitatibus autem excepturi accusamus porro? Harum velit, nemo eum delectus eius quibusdam distinctio exercitationem facilis
            magnam, quidem, ratione fuga. Ipsa
            aliquid exercitationem, debitis illo quibusdam, ipsum ipsam quo incidunt ex doloribus atque cum nisi harum
            sapiente et earum qui sed vitae sit, totam nesciunt ea culpa error tempore. Accusamus modi molestias facere
            consectetur quibusdam error culpa laudantium minima, ipsam id sapiente. Labore temporibus placeat inventore
            praesentium amet ut nihil architecto esse totam voluptates illo aperiam iusto non, vel tenetur a similique
            assumenda. Magnam adipisci odio incidunt, autem numquam ab laboriosam voluptates ratione tempore blanditiis
            aliquid dolor eum delectus error pariatur assumenda earum aspernatur officia iure impedit sit. Similique non
            incidunt accusantium asperiores sit, repellat deleniti voluptate vero doloribus accusamus expedita autem
            itaque ad voluptatem nostrum nam ab officia pariatur debitis quam voluptatibus. Beatae, nostrum corporis
            molestiae similique error nihil odit eligendi quasi adipisci fuga, quis aperiam est eveniet labore. Adipisci
            culpa repellat esse vitae quas molestiae assumenda ullam quae eligendi architecto sequi repudiandae nesciunt
            numquam placeat odio earum omnis quia, a fugit voluptas eveniet? Harum dignissimos nulla incidunt rem iste
            unde dolore excepturi eos. Sit fuga architecto voluptate voluptas, libero quisquam? Amet atque praesentium
            nisi qui, consectetur nobis id cupiditate enim laudantium laboriosam quaerat dignissimos deleniti earum
            illum quos velit distinctio adipisci facilis, ex, quae dolores beatae similique reprehenderit voluptates.
            Animi distinctio dolores placeat beatae soluta nostrum est accusamus, quas corrupti cupiditate reiciendis
            officia! Numquam animi deleniti rem sequi vero eius fugiat fuga est perspiciatis, sed eveniet mollitia
            tenetur consequuntur exercitationem soluta. Quae doloremque nesciunt vero laboriosam a laborum modi aperiam
            placeat!</div>
        <button id="button">Click me</button>
    </div>
    <script type="text/javascript">
        const container = document.getElementById('container');

        const clickMe = document.getElementById('button');

        clickMe.addEventListener('click', async () => {
            container.classList.add('hidden');
            const response = await fetch('/component-testing?name=Nizam+Hakim', {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                },
                method: 'GET',
            });
            const data = await response.text();
            container.innerHTML = data;
            container.classList.remove('hidden');
            window.history.pushState({}, '', '/component-testing?name=Nizam+Hakim');
        });
    </script>
</x-layouts.user-layout>
