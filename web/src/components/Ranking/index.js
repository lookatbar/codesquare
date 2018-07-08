import React, { Component } from 'react';

import { Link } from 'react-router';
import { tabs } from './config';
import Tabbar from '../common/Tabbar';
import './index.less';

class Ranking extends Component{
	constructor(props){
		super(props);

		this.state = {
			keyword: tabs[0].key,
		}
		this.onChangeTab = this.onChangeTab.bind(this);
	}

	onChangeTab(target){
		this.setState({
			keyword: target.key,
		});
	}

	render(){
		const { keyword } = this.state;

		return(
			<div className="ranking transition-item">
				<div className="ranking-tabs">
					<Tabbar 
						tabs={tabs} 
						current={keyword} 
						onSelect={this.onChangeTab} />
				</div>

				<div className="ranking-content">
					{
						keyword === tabs[0].key && 
							<Link className="ranking-item" to="/subject/create?award=1">
								<div className="ranking-item-type">云链创新基金</div>
								<div className="ranking-item-award">最高50000元</div>
								<div className="ranking-item-challenge">挑战</div>
								<i className="iconfont icon-you" />
							</Link>
					}
					{
						keyword === tabs[1].key && 
							<div className="ranking-award">
								<div className="ranking-award-title">报表实现自定义拖拉拽功能</div>
								<div className="ranking-award-content">通过XX实现报表的自定义拖拉拽功能</div>
								<div className="ranking-award-author">高一</div>
								<div className="ranking-award-prize">
									<i className="iconfont icon-shang" />
									5000元
								</div>
								<div className="ranking-award-count">
									<span>
										<i className="iconfont icon-liulan2" />
										500
									</span>
									<span>
										<i className="iconfont icon-weibiaoti-" />
										399
									</span>
									<span>
										<i className="iconfont icon-pinglun" />
										399
									</span>
								</div>
							</div>
					}
				</div>
			</div>
		)
	}
}

export default Ranking;