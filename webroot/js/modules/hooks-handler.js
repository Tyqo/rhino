/**
 * @project       tusk
 * @author        carsten.coull@swu.de
 * @build         Fri, Nov 24, 2023 3:57 PM ET
 * @release       f1fbadc834ac73776f5565c9500257c231e8b826 [main]
 * @copyright     Copyright (c) 2023, SWU Stadtwerke Ulm / Neu-Ulm GmbH
 *
 */
export default class HooksHandler{constructor(e){this.main=e,this.main.debug,this.queue={}}add(e,u){this.queue[e]||(this.queue[e]=[]),this.queue[e].push(u)}call(e,...u){this.queue[e]&&(this.queue[e].forEach((e=>{e(...u)})),delete this.queue[e])}}