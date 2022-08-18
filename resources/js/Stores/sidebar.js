import { defineStore } from "pinia";

export const useSidebarStore = defineStore("sidebar", {
  state: () => ({
    show: false,
  }),

  getters: {},

  actions: {
    toggle(){
      this.show = !this.show;
    }
  },
});
