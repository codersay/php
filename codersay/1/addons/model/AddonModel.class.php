<?php
/**
 * 插件模型 - 数据对象模型
 * @author jason <yangjs17@yeah.net>
 * @version TS3.0
 */
class AddonModel extends Model {

	protected $tableName = 'plugins';
	protected $fields = array(
			0 => 'id',
			1 => 'name',
			2 => 'title',
			3 => 'author',
			4 => 'remark',
			5 => 'version',
			6 => 'status',
			7 => 'uri',
			8 => 'type',
			9 => 'position',
			10 => 'hook',
			11 => 'param'
		);

	private $valid = array();				// 已安装插件
	private $invalid = array();				// 待安装插件
	private $fileAddons = array();			// 插件对象

	/**
	 * 获取所有插件列表
	 * @return array 所有插件列表
	 */
	public function getAddonAllList() {
		$this->_getFileAddons();
		// 获取数据库中的所有插件
        $databaseAddons = $this->where("type='plugin'")->select();
		$this->_validAddons($databaseAddons);

		$this->_invalidAddons();
		$result['valid']['data']   = $this->valid;
		$result['valid']['name']   = "已安装插件";
		$result['invalid']['data'] = $this->invalid;
		$result['invalid']['name'] = "待安装插件";
		return $result;
	}

	/**
	 * 重置所有已安装插件列表缓存
	 * @return array 最新的插件列表
	 */
	public function resetAddonCache() {
		if(empty($this->fileAddons)) {
			$this->_getFileAddons();
		}
		$addonList = $this->getAddonsValid();

		$addonCache = array();
		foreach($addonList as $key => $value) {
			if(isset($this->fileAddons[$value['name']])) {
				$addonCache = $this->_createAddonsCacheData($value['name'],$addonCache);
			}
		}
		$res = S('system_addons_list',$addonCache);

		return $addonCache;
	}

	/**
	 * 获取已安装的插件列表
	 * @return array 已安装的插件列表
	 */
	public function getAddonsValid() {
		$map['status'] = '1';
		$map['type'] = 'plugin';
		return $this->where($map)->select();
	}

	/**
	 * 获取未安装的插件列表
	 * @return array 未安装的插件列表
	 */
	public function getAddonsInvalid() {
		// TODO:待完成
	}

	/**
	 * 通过插件ID停止插件
	 * @param integer $id 插件ID
	 * @return boolean 插件是否停止
	 */
	public function stopAddonsById($id) {
        if(empty($id)) {
        	return false;
        }
        // 将数据库中标示该插件停止
        $result = $this->_stopAddons('id', intval($id));
		return $result ? true : false;
	}

	/**
	 * 通过插件名称停止插件
	 * @param string $name 插件名称
	 * @return boolean 插件是否停止
	 */
	public function stopAddonsByName($name) {
        if(empty($name)) {
        	return false;
        }
        // 将数据库中标示该插件停止
        $result = $this->_stopAddons('name', $name);
		return $result ? true : false;
	}

	/**
	 * 通过插件ID获取插件对象
	 * @param integer $id 插件ID
	 * @return object 指定插件对象
	 */
	public function getAddonObj($id) {
		$data = $this->getAddon($id);
		if($data) {
			$this->_getFileAddons();
			return $this->fileAddons[$data['name']];
		}

		return false;
	}

	/**
	 * 停止插件
	 * @param string $field 查询插件的Key值
	 * @param string $value 查询插件的Value值
	 * @return boolean 插件是否停止
	 */
	private function _stopAddons($field, $value) {
        // 将数据库中标示该插件停止
		$map[$field] = $value;
		if($filed != 'name') {
			$addon = $this->where($map)->find();
			$name = $addon['name'];
		} else {
			$name = $value;
		}
		$save['status'] = '0';
		$result = $this->where($map)->save($save);
		if($result) {
			$addonCacheList = $this->resetAddonCache();
			S('system_addons_list', $addonCacheList);
		}

		return $result ? true : false;
	}

	/**
	 * 通过插件名称启动插件
	 * @param string $name 插件名称
	 * @return boolean 插件是否启动
	 */
	public function startAddons($name) {
		// 先查看该插件是否安装
		$map['name'] = replaceHtmls($name);
		$addon = $this->where($map)->find();
		// 装载缓存列表
		$this->_getFileAddons();
		if(!isset($this->fileAddons[$name])) {
			return false;
			// throw new ThinkException("插件".$name."的目录不存在");
		}
        // 如果安装后启用的，设置插件启动
		if($addon && $addon['status'] == 0) {
			$save['status'] = '1';
			$result = $this->where($map)->save($save) ? true : false;
		} else if($addon && $addon['status'] == 1) {
			$result = false;
		} else {
            $addonObject = $this->fileAddons[$name];
            $add = $addonObject->getAddonInfo();
			$insert['name'] = $name;
			$insert['status'] = '1';
			$insert['version'] = $add['version'];
			$insert['author'] = $add['author'];
			$insert['title'] = $add['pluginName'];
			$insert['remark'] = $add['info'];
			$insert['type'] = 'plugin';
			$insert['uri'] = $add['site'];
			$insert['position'] = $add['position'];
			$insert['hook'] = $add['hook'];
			$insert['param'] = json_encode($add['param']);
			if($this->add($insert) && $addonObject->install()) {
				$result = true;
			} else {
				$result = false;
			}
        }

		if($result) {
			$addonCacheList = $this->resetAddonCache();
			S('system_addons_list', $addonCacheList);
        }

		return $result;
    }

    /**
     * 通过插件名称卸载插件
     * @param string $name 插件名称
     * @return boolean 插件是否卸载成功
     */
    public function uninstallAddons($name) {
        if(empty($name)) {
        	return false;
        }
        $this->_getFileAddons();
        if(!isset($this->fileAddons[$name])) {
        	return false;
        	// throw new ThinkException("插件".$name."不存在");
        }
        $addonObject = $this->fileAddons[$name];
        $addonObject->uninstall();

		$map['name'] = $name;
		$result = $this->where($map)->delete() ? true : false;
		if($result) {
			$addonCacheList = $this->resetAddonCache();
			S('system_addons_list', $addonCacheList);
		}

		return $result;
    }

    /**
     * 获取指定插件信息
     * @param integer $id 插件ID
     * @param integer $status 插件状态
     * @return array 指定插件信息
     */
	public function getAddon($id, $status = 1) {
		$map['id'] = intval($id);
		$status = intval($status);
		$map['status'] = "$status";
		return $this->where($map)->find();
	}

	/**
	 * 获取所有插件管理面板所需数据
	 * @return array 所有插件管理面板所需数据
	 */
	public function getAddonsAdmin() {
		$valid = $this->getAddonsValid();
		$this->_getFileAddons();
		if(empty($valid)) {
			return array();
		}
		$data = array();
		foreach($valid as $value) {
			$obj = isset($this->fileAddons[$value['name']]) ? $this->fileAddons[$value['name']] : null;
			if($obj && $obj->adminMenu()) {
				$data[] = array($value['pluginName'], $value['addonId']);
			}
		}
		
		return $data;
	}

	/**
	 * 创建插件缓存数据
	 * @param string $name 插件名称
	 * @param array $addonList 插件列表
	 * @return array 返回插件列表
	 */
	private function _createAddonsCacheData($name, $addonList) {
        $list = $this->fileAddons[$name]->getHooksList($name);
		// 合并钩子缓存列表
		if(empty($addonList)) {
			$addonList = $list;
        } else {
            $result = array();
            $addonListKey = array_keys($addonList);
            $listKey = array_keys($list);
            $addonList = array_merge_recursive($addonList,$list);
        }

		return $addonList;
	}

	/**
	 * 验证已安装的插件
	 * @param array $databaseAddons 插件列表数据
	 * @return void
	 */
	private function _validAddons($databaseAddons) {
        if(empty($databaseAddons)) {
        	return;
        }
		foreach($databaseAddons as $value) {
			if($value['status'] == 1) {
				$this->valid[] = $value;
			} else {
				$this->invalid[] = $value;
			}
			if(isset($this->fileAddons[$value['name']])) {
				unset($this->fileAddons[$value['name']]);
			}
		}
	}

	/**
	 * 验证未安装的插件
	 * @return void
	 */
	private function _invalidAddons() {
		// 获取未启用的插件
		foreach($this->fileAddons as $key => $value) {
            $data = $value->getAddonInfo();
            $data['status'] = 0;
            $data['name'] = $key;
			$this->invalid[] = $data;
		}
	}

	/**
	 * 设置所有插件对象
	 * @return void
	 */
	private function _getFileAddons() {
		if(!empty($this->fileAddons)) {
			return $this->fileAddons;
		}
		// 获取文件夹下面的所有插件
		$dirName = ADDON_PATH.'/plugin';
		$dir = dir($dirName);
		$fileAddons = array();
		while(false !== $entry = $dir->read()) {
			if($entry == '.' || $entry == '..' || $entry == ".svn") {
				continue;
			}
			$path = $dirName.'/'.$entry;
			$addonsFile = $path.'/'.$entry.'Addons.class.php';
			tsload(CORE_PATH.'addons/AbstractAddons.class.php');
			tsload(CORE_PATH.'addons/NormalAddons.class.php');
			tsload(CORE_PATH.'addons/SimpleAddons.class.php');
			if(file_exists($addonsFile)) {
				tsload($addonsFile);
				$class = $entry . 'Addons';
				$fileAddons[$entry] = new $class();
				$fileAddons[$entry]->setPath($path);
			}
		}

		$this->fileAddons = $fileAddons;
	}

	/**
	 * 获取后台所有插件URL
	 * @return array 后台所有插件URL
	 */
	public function getAddonsAdminUrl() {

		$addons = $this->getAddonsAdmin();
		$r = array();
		foreach($addons as $value) {
			$r[$value[0]] = U('plugins/admin', array('pluginid'=>$value[1]));
		}

		return $r;
	}
}