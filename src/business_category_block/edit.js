import ServerSideRender from '@wordpress/server-side-render';
import { __ } from '@wordpress/i18n';
import { SelectControl, 
    Toolbar,
    Button,
    Tooltip,
    PanelBody,
    PanelRow,
    FormToggle,
    ToggleControl,
    ToolbarGroup,
    Disabled, 
    RadioControl,
    RangeControl,
    FontSizePicker } from '@wordpress/components';

    import {
        RichText,
        AlignmentToolbar,
        BlockControls,
        BlockAlignmentToolbar,
        InspectorControls,
        InnerBlocks,
        withColors,
        PanelColorSettings,
        getColorClassName
    } from '@wordpress/block-editor'
    ;
import { withSelect, widthDispatch } from '@wordpress/data';

const {
    withState
} = wp.compose;

const formatOptions = [
    { label: 'List', value: 'list' },
    { label: 'Grid', value: 'grid' },
 ];

const orderbyOptions = [
    { label: 'Title', value: 'name' },
    { label: 'Count', value: 'count' },
 ];

const orderOptions = [
    { label: 'Ascending', value: 'ASC' },
    { label: 'Descending', value: 'DESC' },
];

const childOfOptions = [
    { label: 'Select a parent category', value: 0 }
];

wp.apiFetch({path: "/wp/v2/business_category?per_page=100"}).then(posts => {
    jQuery.each( posts, function( key, val ) {
        childOfOptions.push({label: val.name, value: val.id});
    });
}).catch( 

)

const excludeCatOptions = [
    { label: 'Select one or more categories', value: 0 }
];

wp.apiFetch({path: "/wp/v2/business_category?per_page=100"}).then(posts => {
    jQuery.each( posts, function( key, val ) {
        excludeCatOptions.push({label: val.name, value: val.id});
    });
}).catch( 

)

const edit = props => {
    const {attributes: {align, cd_block, format, orderby, order, showcount, showCountToggle, hierarchical, hierarchyToggle, hide_empty, hideEmptyToggle, child_of, exclude, excludeCategories, depth }, className, setAttributes } = props;

    const setShowCount = showCountToggle =>{
        props.setAttributes({showCountToggle})
        !! showCountToggle ? __( props.setAttributes({showcount: 1}) ) : __( props.setAttributes({showcount: 0}) );
        
    };

    const setHierarchy = hierarchyToggle =>{
        props.setAttributes({hierarchyToggle})
        !! hierarchyToggle ? __( props.setAttributes({hierarchical: 1}) ) : __( props.setAttributes({hierarchical: 0}) );
        
    };

    const setHideEmpty = hideEmptyToggle =>{
        props.setAttributes({hideEmptyToggle})
        !! hideEmptyToggle ? __( props.setAttributes({hide_empty: 1}) ) : __( props.setAttributes({hide_empty: 0}) );
        
    };

    const setCategories = excludeCategories => {
        props.setAttributes( { excludeCategories} );
    };

    const inspectorControls = (
        <InspectorControls key="inspector">
            <PanelBody title={ __( 'Business Category Block Options' )}>
            <PanelRow>
                    <SelectControl
                        label={ __('Layout Options')}
                        value={ format }
                        options= { formatOptions }
                        onChange={ ( nextValue ) =>
                            setAttributes( { format: nextValue } )
                        }
                    />
                </PanelRow>
                <PanelRow>
                    <SelectControl
                        label={ __('Order By') }
                        value={orderby}
                        options= { orderbyOptions }
                        onChange={ ( nextValue ) =>
                            setAttributes( {orderby:  nextValue } )
                        }
                    />
                </PanelRow>
                <PanelRow>
                    <SelectControl
                        label={ __('Order') }
                        value={order}
                        options= { orderOptions }
                        onChange={ ( nextValue ) =>
                            setAttributes( {order:  nextValue } )
                        }
                    />
                </PanelRow>
                <PanelRow>
                    <SelectControl 
                        label = { __('Show child categories') }
                        value = {child_of}
                        options = {childOfOptions}
                        help = {__('Displays only the child categories of the selected parent category.')}
                        onChange={ ( nextValue ) =>
                            setAttributes( {child_of:  nextValue } )
                        }
                    />
                </PanelRow>
                <PanelRow>
                    <SelectControl
                        multiple
                        className = "cdash_multi_select" 
                        label = { __('Exclude Categories') }
                        value = {excludeCategories}
                        options = {excludeCatOptions}
                        onChange = {setCategories}
                    />
                </PanelRow>
                <PanelRow>
                    <ToggleControl
						label={ __( 'Show the number of businesses in each category' ) }
						checked={ showCountToggle }
                        onChange = {setShowCount}
					/>
                </PanelRow>
                <PanelRow>
                    <ToggleControl
						label={ __( 'Show the categories in hierarchical order' ) }
						checked={ hierarchyToggle }
                        onChange = {setHierarchy}
					/>
                </PanelRow>
                <PanelRow>
                    <ToggleControl
						label={ __( 'Hide Empty Categories' ) }
						checked={ hideEmptyToggle }
                        onChange = {setHideEmpty}
					/>
                </PanelRow>
                <PanelRow>
                    <RangeControl
                        label= { __('Number of child category levels to show') }
                        min={0 }
                        max={ 5 }
                        value={ depth }
                        onChange={ ( value ) => setAttributes( { depth: value} ) }
                        initialPosition = { 0 }
                        //allowReset = { true }
                        //resetFallbackValue = { -1 }
                    />
                </PanelRow>
            </PanelBody>
        </InspectorControls>
    );
    return [
        <div className={ props.className }>
            <ServerSideRender
                block="cdash-bd-blocks/business-category"
                attributes = {props.attributes}
            />
            { inspectorControls }
            <div className="bus_cat">
                
            </div>
        </div>
    ];
};

export default edit;