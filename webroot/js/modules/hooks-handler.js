/**
 * @project       tusk
 * @author        carsten.coull@swu.de
 * @build         Mon, Nov 27, 2023 4:42 PM ET
 * @release       d6815068fe7f024f6df783c14f58618d57dda4e4 [main]
 * @copyright     Copyright (c) 2023, SWU Stadtwerke Ulm / Neu-Ulm GmbH
 *
 */
export default class HooksHandler{constructor(e){this.main=e,this.main.debug,this.queue={}}add(e,u){this.queue[e]||(this.queue[e]=[]),this.queue[e].push(u)}call(e,...u){this.queue[e]&&(this.queue[e].forEach((e=>{e(...u)})),delete this.queue[e])}}