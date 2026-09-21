# LAKA Network Switch Widget

Widget de panel físico para **Zabbix 7.0 LTS**, orientado inicialmente a switches Cisco Catalyst.

Versión actual: **1.0**.

La interfaz detecta automáticamente el tema claro u oscuro activo en Zabbix, reutiliza su tipografía y adapta fondos, bordes, textos, controles, puertos, mapas, gráficas y ventanas emergentes. Los colores funcionales de estado se mantienen para distinguir interfaces operativas, caídas, deshabilitadas o sin datos.

Para Cisco, el resumen prioriza el ítem oficial `system.net.uptime[sysUpTime.0]`. Las claves históricas continúan disponibles como respaldo para plantillas y fabricantes diferentes.

## Topología automática y endpoints

La vista global **Topology**, situada sobre el menú de equipos, combina tres fuentes:

- Vecinos correlacionados automáticamente mediante CDP.
- Vecinos correlacionados automáticamente mediante LLDP.
- Enlaces manuales almacenados como macros de host.

El botón **Endpoints** abre un selector por equipo. Se pueden mostrar los vecinos de uno o varios switches, todos u ocultarlos para evitar mapas saturados. Cada endpoint presenta el hostname, dirección IP, interfaz local, puerto remoto y protocolo disponible. La selección se recuerda en el navegador.

En el resumen de cada equipo hay dos paneles compactos y desplegables: **Endpoints descubiertos** e **Interconexiones de red**. Al pasar el cursor sobre una fila se resalta el puerto correspondiente; al seleccionar una interconexión se abre el equipo vecino monitoreado.

Debajo de los puertos se presenta además un mapa vectorial del equipo seleccionado. Puede alternarse entre **Endpoints**, **Interconexiones** o **Ambos**. Al pulsar cualquier nodo se abre una ventana con los detalles conocidos del vecino o equipo monitoreado, sin abandonar el dashboard.

Todos los mapas incluyen controles de zoom, ajuste al área visible y tamaño diferenciado: los equipos monitoreados se presentan de forma compacta y los endpoints ocupan todavía menos espacio. Los enlaces de endpoints dependen exclusivamente del estado del puerto local descubierto; una advertencia general del switch no altera su color.

Para habilitar el descubrimiento automático, vincule al host las plantillas **LAKA Network Topology - LLDP by SNMP** y, cuando corresponda, **LAKA Network Topology - Cisco CDP by SNMP**.

## Topología manual

La pestaña **Topología** construye un mapa vectorial con los equipos incluidos en el widget. Es útil cuando LLDP o CDP están deshabilitados: un administrador puede registrar directamente los dos extremos, por ejemplo:

```text
SW1 · Gi1/0/47  <-->  FortiGate-LP · port1
```

Cada enlace se guarda en el host del extremo A mediante una macro con contexto:

```text
{$LAKA.TOPOLOGY.LINK:"identificador"}
```

## Gráficas de interfaces destacadas

Active `Show featured interface charts` y defina `Featured interface name/alias (regex)`.

Ejemplos:

```text
^(Gi1/0/47|Gi1/0/48|Te1/1/1)$
```

```text
(Uplink|Core|Firewall|Servidor)
```

El panel acepta entre 1 y 12 interfaces y periodos de 1 hora a 7 días.

## Funciones de la versión 0.1.0

- Descubrimiento automático mediante los índices presentes en las claves de ítems.
- Correlación por `ifIndex`, sin asumir índices consecutivos.
- Nombre, alias, estado administrativo y estado operativo. Cuando la plantilla no crea ítems separados para nombre/alias, se intenta obtenerlos del nombre del ítem descubierto.
- Velocidad, tráfico IN/OUT y utilización porcentual.
- Contadores de errores y descartes.
- Problemas activos asociados automáticamente a los ítems de cada interfaz.
- Separación visual de puertos de acceso y uplinks.
- Agrupación automática de miembros StackWise (`Gi1/...`, `Gi2/...`).
- Filtros configurables mediante expresiones regulares.
- Compatibilidad con dashboard normal y dashboard de plantilla.
- Lista compacta de interfaces con búsqueda, ordenamiento y velocidad negociada.
- Lista expandible/plegable con preferencia recordada por equipo y navegador.
- Vinculación visual entre la fila seleccionada y el puerto físico correspondiente.

## Instalación

1. Copiar la carpeta `laka-network-switch` a:

   ```bash
   /usr/share/zabbix/modules/laka-network-switch
   ```

2. Ajustar propietario y contexto SELinux según la instalación:

   ```bash
   chown -R root:root /usr/share/zabbix/modules/laka-network-switch
   restorecon -Rv /usr/share/zabbix/modules/laka-network-switch
   ```

3. En Zabbix ir a **Administración > General > Módulos**, ejecutar **Escanear directorio** y habilitar **LAKA Network Switch**.
4. Agregar el widget al dashboard, seleccionar el host y guardar.

## Patrones de ítems

Cada patrón debe contener exactamente un `*`, que representa `{#SNMPINDEX}`. Los valores predeterminados siguen un esquema frecuente de plantillas SNMP:

```text
net.if.status[ifOperStatus.*]
net.if.adminstatus[ifAdminStatus.*]
net.if.name[ifName.*]
net.if.alias[ifAlias.*]
net.if.speed[ifHighSpeed.*]
net.if.in[ifHCInOctets.*]
net.if.out[ifHCOutOctets.*]
```

Si la plantilla usa claves como `ifOperStatus[10101]`, configure `ifOperStatus[*]`. No es necesario modificar el código.

## Estados

| Color | Estado |
|---|---|
| Verde | Admin UP y Oper UP |
| Rojo | Admin UP y Oper distinto de UP |
| Gris | Administrativamente deshabilitado |
| Rojo con borde | Problema/trigger activo relacionado con el puerto |

La barra inferior indica utilización: azul normal, ámbar desde 60% y rojo desde 80%.

## Alcance y siguiente versión

Esta primera versión usa el último valor almacenado. La próxima etapa puede incorporar gráficas históricas, VLAN, PoE, CPU, memoria, temperatura, PSU y ventiladores.
