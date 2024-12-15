<script setup lang="ts">
const docStore = useDocumentStore()
const genStore = useGeneralStore()
const props = defineProps({
  mode: {
    type: Boolean
  }
})

// const  modalStatus = ref(true)
const  close = () => {
  docStore.togglePreviewModalStatus(false)
  genStore.resetBlobData()
}

</script>

<template>
  <div class="">
    <el-dialog :before-close="close" v-model="props.mode" :title="genStore.getBlobDataFileName || 'Doc View'" width="88%" center>
      <div class="bg-white">
        <div class="">
          <div class="text-center"><UsableContentLoader  color=""/></div>
          <div>
            <div class="mt-[10px]">
              <div class="">
                <div class="w-full h-auto lg:h-[100vh] md:h-[80vh] sm:h-[72vh] relative">
                  <iframe
                      v-if="genStore.getBlobDataFile"
                      :src="genStore.getBlobDataFile"
                      class="w-full h-full"
                      style="border:none;"
                  >
                  </iframe>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>

      <template #footer>
        <div class="dialog-footer">
          <el-button type="info" @click="close">Cancel</el-button>
        </div>
      </template>
    </el-dialog>
  </div>

</template>

<style scoped>

</style>