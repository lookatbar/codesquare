import React, { Component } from 'react';

import './index.less';

import fieldsetInit from '../decorators/fieldsetInit';

@fieldsetInit({
	title: '',
	content: '',
	topic_type: '',
	// 图片需要单独处理
	// images_list: [],
})
class CreateSubject extends Component{
	constructor(props){
		super(props);

		this.state = {

		}
	}

	onSubmit(){

	}

	render(){
		const { 
			title,
			content,
			topic_type,

			set_title,
			set_content,
			set_topic_type,
		} = this.props;

		return(
			<div className="createSubject">
				<form onSubmit={this.onSubmit}>
					<div className="createSubject-field">
						<textarea 
							maxLength="60"
							placeholder="填写主题"
							onChange={set_title}
							value={title} />
					</div>
					<div className="createSubject-field">
						<textarea 
							rows="5"
							placeholder="说说你的心得或问题吧~"
							onChange={set_content}
							value={content} />
					</div>

					<div className="createSubject-field">
						<label>
							<input type="radio" value="111" checked={topic_type === '111'} onChange={set_topic_type} />
							111
						</label>
						<label>
							<input type="radio" value="222" checked={topic_type === '222'} onChange={set_topic_type} />
							222
						</label>
					</div>

					<div className="createSubject-tools">
						<button 
							type="submit" 
							className="createSubject-btn-submit" 
							children="发布" />
					</div>
				</form>
			</div>
		)
	}
}

export default CreateSubject;