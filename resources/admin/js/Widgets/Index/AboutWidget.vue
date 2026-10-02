<template>
    <div class="flex flex-col h-[98%]">
        <div class="">
            <h5 class="mb-5">Добро пожаловать в панель управления KonturCMS</h5>

            <p>Интернет подарил миру виртуальные путешествия в любые уголки планеты, доступ к неограниченным знаниям
                и
                радость самовыражения. А еще он дал возможность вывести продажи на новый уровень: создание сайта для
                бизнеса
                — неотъемлемый этап маркетинговой стратегии. </p>

            <p>Компания KONTUR — одна из ведущих веб-студий Новосибирска, мы имеем опыт в web-разработке более 10
                лет.
                Профессионализм наших специалистов позволяет нам с вниманием относиться к каждой поставленной задаче
                и
                находить именно то решение, которое будет наиболее результативным для клиента.</p>
        </div>
        <div class="mt-auto flex justify-between mb-2">
            <a href="https://kontur-lite.ru/" class="el-button el-button--danger" target="_blank">Посетить наш сайт</a>
            <a href="tel:(383)2553333" class="el-button el-button--danger">
                <i class="bi bi-telephone-forward-fill me-1"></i> Позвонить
            </a>
        </div>
    </div>
</template>

<script>
import {isEqual} from "lodash";

export default {
    name: "AboutWidget",
    props: {
        data: null,
    },
    data() {
        return {
            position: {
                layerX: 300,
                layerY: 200,
            },
            defaultPosition: {
                layerX: 300,
                layerY: 200,
            }
        }
    },
    computed: {
        positionStyle() {
            return {
                top: (this.position.layerY - 75) + 'px',
                left: (this.position.layerX - 75) + 'px',
            }
        }
    },
    methods: {
        isEqual,
        setDefault() {
            this.position = {...this.defaultPosition}
        },
        mouseMove(target) {
            this.position = {
                layerX: target.layerX,
                layerY: target.layerY,
            }
        }
    }
}
</script>

<style scoped>
.widget {
    z-index: 4;
    position: relative;
    background: transparent;
}

.widget__about {
    border-radius: 8px;
    z-index: 1;
    position: absolute;
    top: 0;
    right: 0;
    width: 100%;
    height: 100%;
    filter: blur(65px);
}

.circle {
    width: 170px;
    height: 170px;
    border-radius: 100%;
    background: linear-gradient(-45deg, #bd34fe 50%, #47caff 50%);
    position: absolute;
    /* bottom: 10%;
     left: 60%;*/
    z-index: -1;
}

.animated {
    transition: 1s;
}
</style>
