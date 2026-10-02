import {defineStore} from 'pinia'

export const useIBlockStore = defineStore('iblock', {
    state: () => ({
        data: []
    }),
    actions: {
        setIBlocks(data) {
            this.data = data
        },
        update(index, iBlock) {
            this.data[index] = iBlock
        },
        add(iBlock) {
            this.data.push(iBlock)
        },
        delete(index) {
            this.data.splice(index, 1)
        }
    },
})
